<template>
    <v-row>
            <card-where />
            <card-how />
            <card-who />
        </v-row>
</template>
<script>
import where from './cards/Where.vue'
import how from './cards/Hov.vue'
import who from './cards/Who.vue'

export default {
    components: {
        'card-where': where,
        'card-how': how,
        'card-who': who,
    }
}
</script>