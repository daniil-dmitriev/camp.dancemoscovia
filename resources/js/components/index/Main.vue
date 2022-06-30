<template>
  <v-row align="center" justify="space-around" class="vh-100">
    <v-col cols="12" md="8">
      <router-link to="/register">
        <v-img
          :lazy-src="settings.image"
          aspect-ratio="1.2"
          contain
          :src="settings.image"
        ></v-img>
      </router-link>
    </v-col>
    <v-col align="end" cols="12" md="4" class="d-none d-md-block">
      <h1>«{{ settings.name }}»</h1>
      <h5>{{ settings.dates }}, {{ settings.place }}</h5>
      <v-btn to="/register" large dark color="#b00845" class="float-right my-2">
        Регистрация
      </v-btn>
    </v-col>
  </v-row>
</template>

<script>
export default {
  data: () => ({
    settings: {},
  }),
  methods: {
    loadSettings() {
      axios.get("api/settings").then((res) => {
        this.settings = res.data;
      });
    },
  },
  mounted() {
    this.loadSettings();
  },
};
</script>
