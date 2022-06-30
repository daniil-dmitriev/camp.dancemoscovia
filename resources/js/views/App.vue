<template>
    <v-app>
        <v-navigation-drawer app right temporary v-model="drawer">
            <v-list nav>
                <v-list-item-group v-model="group">
                    <v-list-item
                        v-for="(link, index) in links"
                        :to="link.href"
                        :key="`link${index}`"
                    >
                        <v-list-item-icon>
                            <v-icon class="mr-3" v-text="link.icon"></v-icon>
                        </v-list-item-icon>
                        <v-list-item-title
                            v-text="link.title"
                        ></v-list-item-title>
                    </v-list-item>
                </v-list-item-group>
            </v-list>
        </v-navigation-drawer>

        <v-app-bar app flat hide-on-scroll color="white">
            <v-container class="py-0 fill-height">
                <v-toolbar-title>
                    <router-link to="/">
                        <v-img src="./images/logo.png" max-width="160px" class="ml-3"></v-img>
                    </router-link>
                </v-toolbar-title>
                <v-spacer></v-spacer>
                <v-toolbar-items class="d-none d-md-flex d-lg-flex d-xl-flex">
                    <v-btn
                        v-for="(link, index) in links"
                        :to="link.href"
                        :key="`link${index}`"
                        text
                        plain
                    >
                        <v-icon dense class="mr-3" v-text="link.icon"></v-icon>
                        {{ link.title }}</v-btn
                    >
                </v-toolbar-items>
                <v-app-bar-nav-icon
                    @click="drawer = true"
                    class="d-md-none d-lg-none d-xl-none d-xs-flex d-sm-flex"
                ></v-app-bar-nav-icon>
            </v-container>
        </v-app-bar>

        <v-main>
            <router-view></router-view>
        </v-main>
    </v-app>
</template>
<script>
export default {
    data() {
        return {
            drawer: false,
            group: null,
            links: [
                {
                    title: "Главная",
                    href: "/",
                    icon: "mdi-home-outline"
                },
                {
                    title: "Регистрация",
                    href: "/register",
                    icon: "mdi-circle-edit-outline"
                },
                {
                    title: "Контакты",
                    href: '/contacts',
                    icon: "mdi-information-outline"
                }
            ]
        };
    }
};
</script>

<style>
</style>
