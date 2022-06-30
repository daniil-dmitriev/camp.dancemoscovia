<template>
    <v-row>
        <v-col cols="12">
            <v-data-table
                :headers="headers"
                :items="coaches"
                :search="coaches_table_search"
                item-key="name"
                group-by="program"
                groupable
                sort-by="name"
                :loading="tables_loading"
                loading-text="Loading... Please wait"
                :items-per-page="10"
            >
                <template v-slot:top>
                    <v-toolbar flat>
                        <v-text-field
                            v-model="coaches_table_search"
                            append-icon="mdi-magnify"
                            label="Search"
                            single-line
                            hide-details
                            dense
                        ></v-text-field>
                        <v-spacer></v-spacer>
                        <v-dialog v-model="dialog.addCoach.visible" persistent>
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn
                                    color="primary"
                                    dark
                                    v-bind="attrs"
                                    v-on="on"
                                >
                                    Add coach
                                </v-btn>
                            </template>
                            <v-card>
                                <v-container>
                                    <v-card-title>
                                        <span class="text-h5">Add Coach</span>
                                        <v-spacer></v-spacer>
                                    </v-card-title>
                                    <v-card-text>
                                        <v-row>
                                            <v-col cols="12">
                                                <v-row
                                                    class="mt-4 border-bottom"
                                                >
                                                    <v-col
                                                        cols="12"
                                                        lg="2"
                                                        md="4"
                                                    >
                                                        <v-text-field
                                                            label="LastName + Name"
                                                            v-model="coach.name"
                                                            hint="Coach name"
                                                            persistent-hint
                                                            dense
                                                        ></v-text-field>
                                                    </v-col>
                                                    <v-col
                                                        cols="12"
                                                        lg="2"
                                                        md="4"
                                                    >
                                                        <v-select
                                                            label="Program"
                                                            :items="
                                                                program_items
                                                            "
                                                            v-model="
                                                                coach.program
                                                            "
                                                            hint="Coach's default program"
                                                            dense
                                                            persistent-hint
                                                        ></v-select>
                                                    </v-col>
                                                    <v-col
                                                        cols="6"
                                                        lg="1"
                                                        md="1"
                                                    >
                                                        <v-select
                                                            label="currency"
                                                            :items="
                                                                currency_items
                                                            "
                                                            v-model="
                                                                coach.currency
                                                            "
                                                            hint="Coach's currency"
                                                            dense
                                                            persistent-hint
                                                        >
                                                        </v-select>
                                                    </v-col>
                                                    <v-col
                                                        cols="6"
                                                        lg="1"
                                                        md="1"
                                                    >
                                                        <v-text-field
                                                            :suffix="
                                                                coach.currency
                                                            "
                                                            placeholder="5000"
                                                            v-model="
                                                                coach.price
                                                            "
                                                            hint="Coach's price"
                                                            persistent-hint
                                                            dense
                                                        ></v-text-field>
                                                    </v-col>
                                                    <v-col
                                                        cols="12"
                                                        lg="1"
                                                        md="2"
                                                    >
                                                        <v-text-field
                                                            suffix="hours"
                                                            placeholder="20"
                                                            hint="Coach's working hours"
                                                            v-model="
                                                                coach.working_hours
                                                            "
                                                            @change="
                                                                fillAvailableHours
                                                            "
                                                            persistent-hint
                                                            dense
                                                        ></v-text-field>
                                                    </v-col>
                                                    <v-col
                                                        cols="12"
                                                        lg="3"
                                                        md="6"
                                                    >
                                                        <v-textarea
                                                            hint="Coach's regalia"
                                                            placeholder="Russian champion, World Champion etc."
                                                            persistent-hint
                                                            auto-grow
                                                            v-model="
                                                                coach.regalia
                                                            "
                                                            rows="2"
                                                            dense
                                                        ></v-textarea>
                                                    </v-col>
                                                    <v-col
                                                        cols="12"
                                                        lg="2"
                                                        md="6"
                                                    >
                                                        <v-text-field
                                                            label="Comments"
                                                            hint="Coach's aviable days, unusual time etc."
                                                            persistent-hint
                                                            v-model="
                                                                coach.comments
                                                            "
                                                            dense
                                                        ></v-text-field>
                                                    </v-col>
                                                </v-row>
                                                <v-row class="mt-4">
                                                    <v-col
                                                        cols="6"
                                                        class="d-flex justify-content-start"
                                                    >
                                                        <v-btn
                                                            color="primary"
                                                            text
                                                            @click="
                                                                dialogAddCoachClose
                                                            "
                                                        >
                                                            Close
                                                        </v-btn>
                                                    </v-col>
                                                    <v-col
                                                        cols="6"
                                                        class="d-flex justify-content-end"
                                                    >
                                                        <v-btn
                                                            color="primary"
                                                            dense
                                                            text
                                                            @click.prevent="
                                                                store
                                                            "
                                                            v-if="!isUpdate"
                                                        >
                                                            Add
                                                        </v-btn>
                                                        <v-btn
                                                            color="primary"
                                                            dense
                                                            text
                                                            @click.prevent="
                                                                update
                                                            "
                                                            v-else
                                                        >
                                                            Update
                                                        </v-btn>
                                                    </v-col>
                                                </v-row>
                                            </v-col>
                                        </v-row>
                                    </v-card-text>
                                </v-container>
                            </v-card>
                        </v-dialog>
                    </v-toolbar>
                </template>
                <template v-slot:[`item.regalia`]="{ item }">
                    {{ item.regalia }}
                </template>
                <template v-slot:[`item.price`]="{ item }">
                    {{ item.price }} {{ item.currency }}
                </template>
                <template v-slot:[`item.actions`]="{ item }">
                    <v-icon small class="mr-2" @click="editItem(item)">
                        mdi-pencil
                    </v-icon>
                    <v-icon small @click="deleteItem(item)">
                        mdi-delete
                    </v-icon>
                    <v-dialog
                        v-model="dialog.deleteCoach.visible"
                        max-width="500px"
                        :retain-focus="false"
                    >
                        <v-card>
                            <v-card-title class="text-h6 text-center text-break"
                                >Are you sure you want to delete «{{
                                    coach.name
                                }}»?</v-card-title
                            >
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn
                                    color="blue darken-1"
                                    text
                                    @click="dialogDeleteCoachClose"
                                    >Cancel</v-btn
                                >
                                <v-btn
                                    color="blue darken-1"
                                    text
                                    @click="dialogDeleteCoachConfirm"
                                    >OK</v-btn
                                >
                                <v-spacer></v-spacer>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                </template>
            </v-data-table>
        </v-col>
    </v-row>
</template>

<script>
export default {
    data: () => ({
        dialog: {
            addCoach: {
                visible: false
            },
            deleteCoach: {
                visible: false
            }
        },
        coaches_table_search: "",
        tables_loading: true,
        isUpdate: false,
        program_items: ["Стандарт", "Латина", "ОФП"],
        currency_items: ["руб", "euro"],
        coach: {
            name: "",
            program: "Стандарт",
            currency: "руб",
            price: "",
            working_hours: "",
            available_hours: "",
            regalia: "",
            comments: ""
        },
        coaches: [],
        headers: [
            {
                text: "Coache's name",
                align: "start",
                value: "name",
                sortable: true,
                width: "20%"
            },
            {
                text: "Price",
                value: "price",
                sortable: false,
                width: "10%"
            },
            {
                text: "Working hours",
                value: "working_hours",
                sortable: false,
                aligh: "center",
                width: "5%"
            },
            {
                text: "Available hours",
                value: "available_hours",
                align: "center",
                width: "5%"
            },
            {
                text: "Regalia",
                value: "regalia",
                sortable: false,
                width: "30%"
            },
            {
                text: "Comments",
                value: "comments",
                width: "20%",
                sortable: false
            },
            { text: "Actions", value: "actions", sortable: false, width: "10%" }
        ]
    }),
    methods: {
        store() {
            axios
                .post("/api/coaches", this.coach, {
                    headers: {
                        "Content-type": "application/json"
                    }
                })
                .then(res => {
                    if (res.data.status) {
                        this.$notification["success"](
                            "Coach added successfully"
                        );
                        this.loadCoaches();
                        this.dialogAddCoachClose();
                    }
                })
                .catch(err => {
                    console.log(err.response.data);
                });

            this.dialog.addCoach.visible = false;
        },
        loadCoaches() {
            axios.get("/api/coaches").then(res => {
                this.coaches = res.data;

                setTimeout(() => {
                    this.tables_loading = false;
                }, 500);
            });
        },
        editItem(item) {
            this.coach = Object.assign({}, item);
            this.isUpdate = true;
            this.dialog.addCoach.visible = true;
        },
        update() {
            axios.put("/api/coaches/" + this.coach.id, this.coach).then(res => {
                this.dialog.addCoach.visible = false;
                this.$notification["success"]("Coach updated successfully");
                this.coach = {};
                this.loadCoaches();
            });
        },
        deleteItem(item) {
            this.coach = Object.assign({}, item);
            this.dialog.deleteCoach.visible = true;
        },
        dialogAddCoachClose() {
            this.dialog.addCoach.visible = false;
            this.isUpdate = false;

            this.coach = {};
        },
        dialogDeleteCoachConfirm() {
            axios.delete("/api/coaches/" + this.coach.id).then(res => {
                this.dialogDeleteCoachClose();
                this.$notification["success"]("Coach deleted successfully");

                this.loadCoaches();
            });
        },
        dialogDeleteCoachClose() {
            this.coach = {
                name: "",
                program: "Стандарт",
                currency: "Руб",
                price: "",
                working_hours: "",
                available_hours: "",
                regalia: "",
                comments: ""
            };
            this.dialog.deleteCoach.visible = false;
        },
        fillAvailableHours() {
            this.coach.available_hours = this.coach.working_hours;
        },
    },
    mounted() {
        this.loadCoaches();
    },
    components: {}
};
</script>
