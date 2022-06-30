<template>
    <v-row>
        <v-col cols="12">
            <v-data-table
                :headers="headers"
                expanded.sync="expanded"
                show-expand
                :items="datatable_items"
                item-key="visitor"
                loading="true"
                hide-default-footer
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
                <template v-slot:[`item.category`]="{ item }">
                    {{ item.category }}
                </template>
                <template v-slot:[`item.comments`]="{ item }">
                    {{ item.comments }}
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
                                    <td>{{ register.coach }}</td>
                                    <td>{{ register.taked_hours }}</td>
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

export default {
    data: () => ({
        headers: [
            {
                text: "Visitors",
                align: "center",
                sortable: true,
                value: "visitor"
            },
            {
                text: "Coach",
                sortable: true,
                value: "coach"
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
        visitors: [],
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
                    this.visitors.forEach(visitor => {
                        let datatable_item = {
                            visitor: visitor.name,
                            registers: res.data.filter(
                                item =>
                                    item.dancers.trim() == visitor.name.trim()
                            ),
                            hours: 0,
                            category: visitor.category,
                            comments: visitor.comments
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
        loadVisitors() {
            axios
                .get("api/users")
                .then(res => {
                    this.visitors = res.data;
                    this.loadRegister();
                })
                .catch(err => {
                    console.log(err.response.data.message);
                });
        },
        createReport() {
            const date = moment().format("DD.MM.YY");
            const filename = date + " visitor_report.xlsx";

            axios
                .get("api/reportVisitor?filename=" + filename, {
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
        },
        getTime(time) {
            return moment(time).format("DD.MM.YYYY  hh:mm:ss");
        },
        deleteRegister(item) {
            this.dialog.deleteRegister.visible = true;
            this.dialog.deleteRegister.item = item;
        },
        deleteRegisterConfirm() {
            axios
                .delete("/api/register/" + this.dialog.deleteRegister.item.id)
                .then(() => {
                    this.$notification["success"](
                        "This register record was deleted"
                    );
                    this.dialog.deleteRegister.visible = false;
                    this.datatable_items = [];
                    this.loadVisitors();
                })
                .catch(err => {
                    console.log(err.response.data);
                });
        }
    },
    mounted() {
        this.loadVisitors();
    }
};
</script>
