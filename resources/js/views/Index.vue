<template>
    <v-container>
        <index-main />
        <index-about />
    </v-container>
</template>

<script>
// additional component import
import main from "../components/index/Main.vue";
import about from "../components/index/About.vue";


export default {
    name: "Index",
    components: {
        "index-main": main,
        "index-about":about,
    }
};
</script>

<style scoped>
h1 {
    font-size: 2.5rem;
}
p {
    font-size: 1rem;
}
.stepper-text {
    font-size: 0.8rem;
    flex-basis: 150px;
}
a {
    color: darkred;
}
</style>
