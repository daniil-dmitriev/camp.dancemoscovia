<template>
    <v-container>
        <page-name :name="name" :tooltip="tooltip" />
        <v-row>
            <v-expansion-panels v-model="panel" multiple>
                <v-expansion-panel>
                    <v-expansion-panel-header
                        >Main settings</v-expansion-panel-header
                    >
                    <v-expansion-panel-content>
                        <main-settings />
                    </v-expansion-panel-content>
                </v-expansion-panel>
                <v-expansion-panel>
                    <v-expansion-panel-header
                        >Coach settings</v-expansion-panel-header
                    >
                    <v-expansion-panel-content>
                        <coach-settings />
                    </v-expansion-panel-content>
                </v-expansion-panel>
                <v-expansion-panel>
                    <v-expansion-panel-header
                        >Coach report settings</v-expansion-panel-header
                    >
                    <v-expansion-panel-content>
                        <coach-report-settings />
                    </v-expansion-panel-content>
                </v-expansion-panel>
                <v-expansion-panel>
                    <v-expansion-panel-header
                        >Visitor settings</v-expansion-panel-header
                    >
                    <v-expansion-panel-content>
                        <visitor-settings />
                    </v-expansion-panel-content>
                </v-expansion-panel>
                <v-expansion-panel>
                    <v-expansion-panel-header>
                        Visitor report Settings
                    </v-expansion-panel-header>
                    <v-expansion-panel-content>
                        <visitor-report-settings />
                    </v-expansion-panel-content>
                </v-expansion-panel>
            </v-expansion-panels>
        </v-row>
        <v-footer v-if="user" app bottom class="text-center" padless>
            <v-spacer></v-spacer>
            {{ user.email }}
            <v-btn text @click="logout()" dense>logout</v-btn>
        </v-footer>
    </v-container>
</template>

<script>
// interface components
import PageName from "../components/interface/PageName.vue";
import CoachSettings from "../components/settings/CoachSettings.vue";
import MainSettings from "../components/settings/MainSettings.vue";
import CoachReportSettings from "../components/settings/CoachReportSettings.vue";
import VisitorSettings from "../components/settings/VisitorSettings.vue";
import VisitorReportSettings from '../components/settings/VisitorReportSettings.vue';


export default {
    data: () => ({
        name: "Настройки сайта",
        tooltip: "Отредактируйте необходимые поля",
        user: null,
        panel: [0]
    }),

    components: {
        PageName,
        MainSettings,
        CoachSettings,
        CoachReportSettings,
        VisitorSettings,
        VisitorReportSettings,
    },
    methods: {
        logout() {
            axios.post("api/logout").then(() => {
                this.$router.push({ name: "index" });
            });
        }
    },
    mounted() {
        axios.get("api/users/1").then(res => {
            this.user = res.data;
        });
    }
};
</script>
