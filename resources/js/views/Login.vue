<template>
    <v-container>
        <v-row justify="space-around" align="center" class="vh-100">
            <v-col cols="12" sm="10" md="8" lg="6">
                <v-form ref="form" @submit.prevent="login()">
                    <v-container>
                        <v-row justify="space-around mb-5">
                            <h5>Authorization</h5>
                        </v-row>
                        <v-row>
                            <v-text-field
                                v-model="user.email"
                                label="Login"
                                dense
                                outlined
                            ></v-text-field>
                        </v-row>
                        <v-row>
                            <v-text-field
                                v-model="user.password"
                                label="Password"
                                dense
                                outlined
                                type="password"
                            ></v-text-field>
                        </v-row>
                        <v-row justify="space-around">
                            <v-btn color="primary" type="submit">Login</v-btn>
                        </v-row>
                    </v-container>
                </v-form>
            </v-col>
        </v-row>
    </v-container>
</template>
<script>
export default {
    data: () => ({
        user: {
            email: "",
            password: ""
        }
    }),
    methods: {
        login() {
            axios.post("/api/login", this.user).then(res => {
                this.$router.push({ name: "settings" });
            });
        }
    }
};
</script>
