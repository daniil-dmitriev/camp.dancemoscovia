<template>
    <v-row>
        <v-col cols="12">
            <v-data-table
                :headers="headers"
                :items="datatable_items"
                :search="search"
                :single-expand="singleExpand"
                :expanded.sync="expanded"
                item-key="coach"
                loading="true"
                hide-default-footer
                show-expand
            >
                <template v-slot:top>
                    <v-toolbar flat>
                        <v-text-field
                            label="Search"
                            v-model="search"
                            outlined
                            dense
                            class="pt-5"
                        ></v-text-field>
                        <v-spacer></v-spacer>
                        <v-btn color="primary" dense @click="createReport">
                            <v-icon left>mdi-pencil</v-icon> Отчет по
                            заявкам</v-btn
                        >
                    </v-toolbar>
                </template>
                <template v-slot:[`item.taked_hours`]="{ item }">
                    {{ item.hours }}
                </template>
                <template v-slot:expanded-item="{ item }">
                    <td :colspan="headers.length">
                        <v-simple-table dark dense>
                            <tbody>
                                <tr
                                    v-for="register in item.registers"
                                    :key="register.id"
                                >
                                    <td>{{ getTime(register.created_at) }}</td>
                                    <td>{{ register.dancers }}</td>
                                    <td class="text-left">
                                        {{ register.category }}
                                    </td>
                                    <td>{{ register.taked_hours }}</td>
                                    <td>{{ register.comments }}</td>
                                    <td>
                                        <v-icon
                                            small
                                            @click="deleteRegister(register)"
                                            >mdi-delete</v-icon
                                        >
                                    </td>
                                </tr>
                            </tbody>
                        </v-simple-table>
                    </td>
                </template>
            </v-data-table>
        </v-col>
        <v-col cols="12">
            <v-dialog v-model="dialog.deleteRegister.visible" max-width="500px">
                <v-card>
                    <v-card-title class="text-h5"
                        >Are you sure you want to delete this
                        item?</v-card-title
                    >
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="blue darken-1"
                            text
                            @click="dialog.deleteRegister.visible = false"
                            >Cancel</v-btn
                        >
                        <v-btn
                            color="blue darken-1"
                            text
                            @click="deleteRegisterConfirm"
                            >OK</v-btn
                        >
                        <v-spacer></v-spacer>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-col>
    </v-row>
</template>
<script>
import moment from "moment";
moment.locale("ru");

export default {
    data: () => ({
        headers: [
            {
                text: "Coach",
                sortable: true,
                value: "coach"
            },
            {
                text: "Dancers",
                align: "center",
                sortable: true,
                value: "dancers"
            },
            {
                text: "Category",
                align: "center",
                sortable: true,
                value: "category"
            },
            {
                text: "Taked hours",
                align: "center",
                sortable: false,
                value: "taked_hours"
            },
            {
                text: "Comments",
                sortable: false,
                value: "comments"
            },
            { text: "", value: "data-table-expand" }
        ],
        singleExpand: false,
        expanded: [],

        coaches: [],
        datatable_items: [],
        search: "",

        dialog: {
            deleteRegister: {
                visible: false,
                item: {}
            }
        }
    }),
    methods: {
        loadRegister() {
            axios
                .get("api/register")
                .then(res => {
                    this.coaches.forEach(coach => {
                        let datatable_item = {
                            coach: coach.name,
                            registers: res.data.filter(
                                item => item.coach.trim() == coach.name.trim()
                            ),
                            hours: 0
                        };
                        let previously_hours = 0;
                        datatable_item.registers.forEach(item => {
                            previously_hours += item.taked_hours;
                        });
                        datatable_item.hours = previously_hours;
                        this.datatable_items.push(datatable_item);
                    });
                })
                .catch(err => {
                    console.log(err);
                });
        },
        loadCoaches() {
            axios.get("api/coaches").then(res => {
                this.coaches = res.data;
                this.loadRegister();
            });
        },
        getTime(time) {
            return moment(time).format("DD.MM.YYYY  hh:mm:ss");
        },
        deleteRegister(register) {
            this.dialog.deleteRegister.item = register;
            this.dialog.deleteRegister.visible = true;
        },
        deleteRegisterConfirm() {
            axios
                .delete("/api/register/" + this.dialog.deleteRegister.item.id)
                .then(() => {
                    this.$notification["success"](
                        "This register record was deleted"
                    );
                    this.dialog.deleteRegister.visible = false;
                    this.loadCoaches();
                })
                .catch(err => {
                    console.log(err.response.data);
                });
        },
        createReport() {
            const date = moment().format("DD.MM.YY");
            const filename = date + " coach_report.xlsx";

            axios
                .get("/api/reportCoach?filename=" + filename, {
                    responseType: "blob"
                })
                .then(res => {
                    console.log(res.data);
                    const url = window.URL.createObjectURL(
                        new Blob([res.data])
                    );
                    const link = document.createElement("a");
                    link.href = url;

                    link.setAttribute("download", filename);
                    document.body.appendChild(link);
                    link.click();
                })
                .catch(err => {
                    console.log(err);
                });
        }
    },
    mounted() {
        this.loadCoaches();
    }
};
</script>
