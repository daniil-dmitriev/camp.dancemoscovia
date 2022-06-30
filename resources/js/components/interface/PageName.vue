<template>
    <v-row class="border-bottom">
        <v-col cols="12" lg="6">
            <h1 class="text-left">{{ name }}</h1>
            <h6> {{ tooltip }}</h6>
        </v-col>
    </v-row>
</template>

<script>
export default {
    props: {
        name: String,
        tooltip: String
    }
};
</script>
