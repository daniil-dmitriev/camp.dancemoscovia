<template>
    <v-container>
        <v-row class="border-bottom">
            <v-col cols="8" md="3">
                <v-file-input v-model="camp_info" dense outlined label="Camp info"></v-file-input>
            </v-col>
            <v-col cols="4" md="1">
                <v-btn @click="addCampInfoFromExcel" dense color="primary"
                    >*.xlsx</v-btn
                >
            </v-col>
            <v-col cols="8" md="3">
                <v-file-input v-model="coach_price" dense outlined label="Coache's price"></v-file-input>
            </v-col>
            <v-col cols="4" md="1">
                <v-btn @click="addCoachPrice" dense color="primary"
                    >*.pdf</v-btn
                >
            </v-col>
            <v-col cols="8" md="3">
                <v-file-input v-model="add_moscovia" dense outlined label="Moscovia coaches and members"></v-file-input>
            </v-col>
            <v-col cols="4" md="1">
                <v-btn @click="addMoscovia" dense color="primary"
                    >*.xlsx</v-btn
                >
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12" md="4">
                <v-text-field
                    v-model="settings.name"
                    dense
                    label="Camp-name"
                    @change="save()"
                ></v-text-field>
            </v-col>
            <v-col cols="12" md="4">
                <v-text-field
                    v-model="settings.dates"
                    dense
                    label="Camp-dates"
                    @change="save()"
                ></v-text-field>
            </v-col>
            <v-col cols="12" md="4">
                <v-select
                    v-model="settings.place"
                    :items="place_items"
                    dense
                    @change="save()"
                >
                </v-select>
            </v-col>
        </v-row>
        <v-row class="align-center d-flex">
            <v-col cols="8" class="align-center">
                <v-radio-group
                    v-model="settings.step"
                    row
                    label="Camp-steps"
                    dense
                    @change="save()"
                >
                    <v-radio value="1" label="шаг 1"></v-radio>
                    <v-radio value="2" label="шаг 2"></v-radio>
                    <v-radio value="3" label="шаг 3"></v-radio>
                    <v-radio value="4" label="шаг 4"></v-radio>
                    <v-radio value="5" label="шаг 5"></v-radio>
                    <v-radio value="6" label="шаг 6"></v-radio>
                    <v-radio value="7" label="шаг 7"></v-radio>
                    <v-radio value="8" label="шаг 8"></v-radio>
                </v-radio-group>
            </v-col>
            <v-col cols="4">
                <form
                    @submit.prevent="imageFormSubmit"
                    id="image-form-submit"
                    enctype="multipart/form-data"
                >
                    <v-row>
                        <v-col cols="8">
                            <v-file-input
                                label="select file"
                                v-model="settings.image"
                                accept="image/*"
                                dense
                            ></v-file-input>
                        </v-col>
                        <v-col>
                            <v-btn
                                color="primary"
                                type="submit"
                                dense
                                form="image-form-submit"
                                >Upload</v-btn
                            >
                        </v-col>
                    </v-row>
                </form>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="6">
                <v-text-field
                    v-model="settings.dates_array"
                    outlined
                    dense
                    label="dates_array"
                    @change="save()"
                ></v-text-field>
            </v-col>
            <v-col cols="6">
                <v-text-field
                    v-model="settings.special_guests"
                    outlined
                    dense
                    label="Camp-special-guests"
                    @change="save()"
                ></v-text-field>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import axios from "axios";

export default {
    data: () => ({
        settings: {
            image: []
        },
        place_items: ["ТЗ «Московия»", "УСЗ «Аквариум»"],
        camp_info: [],
        coach_price: [],
        add_moscovia: []
    }),
    methods: {
        imageFormSubmit() {
            const config = {
                headers: {
                    "content-type": "multipart/form-data"
                }
            };
            let data = new FormData();
            data.append("image", this.settings.image);
            axios
                .post("api/settings", data, config)
                .then(() => {
                    this.$notification["success"](
                        "Image was successfully updated"
                    );
                })
                .catch(function() {
                    this.$notification["error"](
                        "Server error while adding image"
                    );
                });
        },
        save() {
            axios
                .put("api/settings/" + this.settings.id, this.settings)
                .then(res => {
                    if (res.data) {
                        this.$notification["success"]("Successfully updated");
                    } else {
                        console.log(res);
                    }
                });
        },
        loadSettings() {
            axios
                .get("api/settings")
                .then(res => {
                    this.settings = res.data;
                    this.settings.image = [];
                })
                .catch(err => {
                    console.log(err.response);
                });
        },
        addCampInfoFromExcel() {
            const config = {
                headers: {
                    "content-type": "multipart/form-data"
                }
            };
            let data = new FormData();
            data.append("xlsx", this.camp_info);
            axios
                .post("api/addCampInfoFromExcel", data, config)
                .then(res => {
                    console.log(res.data);
                    if (res.data.status == "success") {
                        this.$notification["success"](
                            "Camp info was successfully updated!"
                        );
                        setTimeout(() => {
                            this.$router.go();
                        }, 4000);
                    }
                })
                .catch(err => {
                    this.$notification["error"](err.response.data.message);
                    console.log(err.response.data.message);
                });
        },
        addCoachPrice() {
            const config = {
                headers: {
                    "content-type": "multipart/form-data"
                }
            };
            let data = new FormData();
            data.append("pdf", this.coach_price);
            axios
                .post("api/addCoachPrice", data, config)
                .then(res => {
                    console.log(res.data);
                    if (res.data.status == "success") {
                        this.$notification["success"](
                            "Coaches price-list was successfully added!"
                        );
                    }
                })
                .catch(err => {
                    this.$notification["error"](err.response.data.message);
                    console.log(err.response.data.message);
                });
        },
        addMoscovia() {
            const config = {
                headers: {
                    "content-type": "multipart/form-data"
                }
            };
            let data = new FormData();
            data.append("xlsx", this.add_moscovia);
            axios
                .post("api/addMoscoviaFromExcel", data, config)
                .then(res => {
                    console.log(res.data);
                    if (res.data.status == true) {
                        this.$notification["success"](
                            "Moscovia's file was successfully uploaded!"
                        );
                    }
                })
                .catch(err => {
                    this.$notification["error"](err.response.data.message);
                    console.log(err.response.data.message);
                });
        }
    },
    mounted() {
        this.loadSettings();
    }
};
</script>
