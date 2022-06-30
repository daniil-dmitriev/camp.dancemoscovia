<template>
    <v-row>
        <v-col cols="12" class=" d-md-block d-lg-block d-none">
            <h2 align-self="start">План мероприятий на сезон 2021-2022</h2>
            <v-stepper class="mt-8" elevation="0">
                <v-stepper-header>
                    <v-stepper-step
                        step="1"
                        class="stepper-text"
                        :complete="stepper > 1"
                    >
                        «Летние сборы»
                        <small>Чебоксары, 27.07-05.08.21</small>
                    </v-stepper-step>

                    <v-divider></v-divider>

                    <v-stepper-step
                        step="2"
                        class="stepper-text"
                        :complete="stepper > 2"
                    >
                        «Мощный старт»
                        <small>Московия, 26.08-30.08.21</small>
                    </v-stepper-step>

                    <v-divider></v-divider>

                    <v-stepper-step
                        step="3"
                        class="stepper-text"
                        :complete="stepper > 3"
                    >
                        «ROC-2021»
                        <small>Московия, 13.10-17.10.21</small>
                    </v-stepper-step>

                    <v-divider></v-divider>

                    <v-stepper-step
                        step="4"
                        class="stepper-text"
                        :complete="stepper > 4"
                    >
                        «Узнай свой потенциал»
                        <small>Крокус, 30.11-03.12.21</small>
                    </v-stepper-step>
                </v-stepper-header>
            </v-stepper>
            <v-stepper v-model="stepper" elevation="0">
                <v-stepper-header>
                    <v-stepper-step
                        step="5"
                        class="stepper-text"
                        :complete="stepper > 5"
                    >
                        «ЧиП Москвы»
                        <small>Московия, 03.01-09.01.22</small>
                    </v-stepper-step>

                    <v-divider></v-divider>
                    <v-stepper-step
                        step="6"
                        class="stepper-text"
                        :complete="stepper > 6"
                    >
                            «ЧиП России»
                        <small>Московия, 16.03-20.03.22</small>
                    </v-stepper-step>
                    <v-divider></v-divider>

                    <v-stepper-step
                        step="7"
                        class="stepper-text"
                        :complete="stepper > 7"
                    >
                        «Техника - наше всё!»
                        <small>Крокус, 03.05-06.05.22</small>
                    </v-stepper-step>

                    <v-divider></v-divider>

                    <v-stepper-step
                        step="8"
                        class="stepper-text"
                        :complete="stepper > 8"
                    >
                        «Sochi-2022»
                        <small>Московия, 08.06-19.06.22</small>
                    </v-stepper-step>
                </v-stepper-header>
            </v-stepper>
        </v-col>
    </v-row>
</template>

<script>
export default {
    data: () => ({
        stepper: null
    }),
    methods: {
        loadSettings() {
            axios.get("api/settings").then(res => {
                this.stepper = res.data.step;
            });
        }
    },
    mounted() {
        this.loadSettings();
    }
};
</script>
<style scoped></style>
