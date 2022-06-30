<template>
  <v-col cols="12" md="4" min-height="500px" align-self="start">
    <v-card elevation="0">
      <v-img
        src="./images/chris.jpeg"
        class="white--text align-end"
        gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
        width="100%"
      >
        <v-card-title>Кто работает на сборах?</v-card-title>
      </v-img>
      <v-card-title>Лучшие педагоги страны и мира!</v-card-title>
      <v-card-text>
        На сборах, организованных ТСК «Московия», всегда работают только лучшие
        специалисты. В дополнение к штатным педагогам «Московии» организаторы
        всегда стараются приглашать танцевальных экспертов из других клубов и
        федераций. <br /> <br>
        На предстоящие сборы перед традиционным турниром «Танцевальная Московия»
        приглашены большое количество педагогов ТОП уровня. С полным списком
        педагогов можно ознакомиться в разделе регистраци.
        <!-- :
                <ul>
                    <li v-for="(guest, index) in special_guests" :key="index"> {{ guest }};</li>
                </ul>
                С полным списком педагогов, принимающих участия и датами их
                работы, можно ознакомиться при
                <router-link to="/register">регистрации на сборы</router-link>.
                <br /> -->
        <br />
        Торопитесь, свободные заявки на уроки заканчиваются очень быстро!
      </v-card-text>
    </v-card>
  </v-col>
</template>

<script>
export default {
  data: () => ({
    special_guests: [],
  }),
  methods: {
    loadSettings() {
      axios.get("api/settings").then((res) => {
        this.special_guests = res.data.special_guests.split(", ");
      });
    },
  },
  mounted() {
    this.loadSettings();
  },
};
</script>
