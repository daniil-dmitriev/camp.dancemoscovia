<template>
    <v-col cols="12" md="4" min-height="500px" align-self="start">
        <v-card elevation="0">
            <v-img
                src="./images/dancehall.jpeg"
                class="white--text align-end"
                gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
                width="100%"
            >
                <v-card-title>Где будут проходить?</v-card-title>
            </v-img>
            <v-card-title class="text-break"
                >{{ this.settings.place }},
                {{ this.settings.dates }}!</v-card-title
            >
            <v-card-text>
                Предстоящая танцевально спортивные сборы будут проходить в
                танцевальном зале «Московия» (м. Нагорная, БЦ «Фаворит»).
                <br /><br />
                В распоряжение танцоров на время сборов предоставляются:
                <ul>
                    <li>
                        Три танцевальных зала с мягким дубовым паркетом, общей
                        площадью более 1000м2;
                    </li>
                    <li>
                        Кафе с вкусной домашней едой;
                    </li>
                    <li>
                        Массажный кабинет
                    </li>
                    <li>
                        Отдельные специально подготовленные раздевалки для
                        приезжих танцоров;
                    </li>
                </ul>
                <br />
                Для прохода на территорию БЦ «Фаворит», необходимо оформить
                бумажный пропуск. Для оформления пропуска, свяжитесь с
                <a
                    href="https://wa.me/79031040009?text=%D0%97%D0%B4%D1%80%D0%B0%D0%B2%D1%81%D1%82%D0%B2%D1%83%D0%B9%D1%82%D0%B5%2C%20%D0%9C%D0%BE%D1%81%D0%BA%D0%BE%D0%B2%D0%B8%D1%8F!%0A%D0%9C%D1%8B%20%D0%B1%D1%8B%20%D1%85%D0%BE%D1%82%D0%B5%D0%BB%D0%B8%20%D0%B7%D0%B0%D0%BA%D0%B0%D0%B7%D0%B0%D1%82%D1%8C%20%D0%BF%D1%80%D0%BE%D0%BF%D1%83%D1%81%D0%BA%20%D0%BD%D0%B0%20%D0%BF%D1%80%D0%B5%D0%B4%D1%81%D1%82%D0%BE%D1%8F%D1%89%D0%B8%D0%B5%20%D1%81%D0%B1%D0%BE%D1%80%D1%8B!"
                    >администратором</a
                >
                или укажите необходимые данные при
                <router-link to="/register">регистрации</router-link>.
            </v-card-text>
        </v-card>
    </v-col>
</template>

<script>
export default {
    data: () => ({
        settings: {}
    }),
    methods: {
        loadSettings() {
            axios.get("api/settings").then(res => {
                this.settings = res.data;
            });
        }
    },
    mounted() {
        this.loadSettings();
    }
};
</script>
