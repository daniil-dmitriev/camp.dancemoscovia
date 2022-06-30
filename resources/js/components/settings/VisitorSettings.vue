<template>
    <v-row>
        <v-col cols="12">
            <v-data-table
                :headers="headers"
                :items="users"
                :search="search"
                item-key="email"
                hide-default-footer
                loading-text="Loading... Please wait"
            >
                <template v-slot:top>
                    <v-toolbar flat>
                        <v-text-field
                            v-model="search"
                            dense
                            outlined
                            label="Search"
                            hide-details
                        ></v-text-field>
                    </v-toolbar>
                </template>
                <template v-slot:[`item.actions`]="{ item }">
                    <v-icon @click="editVisitor(item)" small class="mr-2"
                        >mdi-pencil</v-icon
                    >
                    <v-icon @click="deleteVisitor(item)" small
                        >mdi-delete</v-icon
                    >
                </template>
            </v-data-table>
            <v-dialog v-model="dialog.deleteVisitor.visible" max-width="500px">
                <v-card>
                    <v-card-title>
                        Are you sure about deleting
                        {{ this.dialog.deleteVisitor.item.name }}?
                    </v-card-title>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="blue darken-1"
                            text
                            @click="dialog.deleteVisitor.visible = false"
                            >Cancel</v-btn
                        >
                        <v-btn
                            color="blue darken-1"
                            text
                            @click="deleteVisitorConfirm"
                            >OK</v-btn
                        >
                        <v-spacer></v-spacer>
                    </v-card-actions>
                </v-card>
            </v-dialog>
            <v-dialog v-model="dialog.editVisitor.visible" max-width="500px">
                <v-card>
                    <v-card-title>
                        Edit visitor
                    </v-card-title>
                    <v-card-text>
                        <v-container>
                            <v-row>
                                <v-col cols="12">
                                    <v-text-field
                                        v-model="dialog.editVisitor.item.name"
                                        label="name of visitors"
                                        dense
                                        outlined
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field
                                        v-model="dialog.editVisitor.item.email"
                                        label="email of visitors"
                                        dense
                                        outlined
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn
                            @click="dialog.editVisitor.visible = false" text color="primary"
                        >Close</v-btn>
                        <v-spacer></v-spacer>
                        <v-btn @click="editVisitorConfirm" color="primary" text dense
                            >Save</v-btn
                        >
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-col>
    </v-row>
</template>
<script>
export default {
    data: () => ({
        headers: [
            {
                text: "Name",
                align: "left",
                value: "name",
                sortable: "true"
            },
            {
                text: "Email",
                align: "left",
                value: "email"
            },
            {
                text: "Actions",
                align: "center",
                value: "actions"
            }
        ],
        users: [],
        search: "",

        dialog: {
            deleteVisitor: {
                visible: false,
                item: {}
            },
            editVisitor: {
                visible: false,
                item: {}
            }
        }
    }),
    methods: {
        loadVisitors() {
            axios.get("api/users").then(res => {
                this.users = res.data;
            });
        },
        deleteVisitor(visitor) {
            this.dialog.deleteVisitor.item = visitor;
            this.dialog.deleteVisitor.visible = true;
        },
        deleteVisitorConfirm() {
            axios
                .delete("api/users/" + this.dialog.deleteVisitor.item.id)
                .then(res => {
                    if (res.data.status) {
                        this.dialog.deleteVisitor.visible = false;
                        this.$notification["success"](res.data.message);
                        this.loadVisitors();
                    } else {
                        this.$notification["error"](res.data.message);
                    }
                });
        },
        editVisitor(visitor) {
            this.dialog.editVisitor.item = visitor;
            this.dialog.editVisitor.visible = true;
        },
        editVisitorConfirm() {
            this.dialog.editVisitor.visible = false;
            axios
                .put("api/users/" + this.dialog.editVisitor.item.id, this.dialog.editVisitor.item)
                .then(res => {
                    if (res.data.status) {
                        this.$notification["success"](res.data.message);
                        this.loadVisitors();
                    }
                })
                .catch(err => {
                    console.log(err.response.data.message);
                });
        }
    },
    mounted() {
        this.loadVisitors();
    }
};
</script>
