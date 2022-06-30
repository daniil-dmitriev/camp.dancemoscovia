<template>
    <v-container>
        <v-row>
            <v-col cols="12">
                <page-name :name="name" :tooltip="tooltip"></page-name>
            </v-col>
        </v-row>
        <v-row align="center">
            <v-col cols="12" class="mt-4">
                <h2>Как добраться?</h2>
            </v-col>
            <v-col cols="12" md="6">
                <p>
                    Предстоящие сборы «{{ this.settings.name }}» будут проходить
                    в детском республиканском санатории "Лесная сказка". 
                </p>
                <h5>Полный адрес:</h5>
                <p>
                    Чувашская республика, Моргаушский район, д. Шомиково
                </p>
                <!-- <h5>Ближайшее метро:</h5>
                <p>
                    м. Нагорная.
                    <a href="https://yandex.ru/maps/-/CCU5B2BIwB"
                        >Схема прохода в зал от метро</a
                    >.
                </p>
                <h5>
                    Оформление пропуска:
                </h5>
                <p>
                    Танцевальный зал располагается на территории бизнес-центра
                    «Фаворит». Для прохода на территорию зала необходимо
                    оформить специальный одноразовый пропуск. Заказать пропуск
                    можно через <v-icon small>mdi-whatsapp</v-icon>Whatsapp,
                    пройдя по следующей ссылке —
                    <a
                        href="https://wa.me/79031040009?text=%D0%97%D0%B4%D1%80%D0%B0%D0%B2%D1%81%D1%82%D0%B2%D1%83%D0%B9%D1%82%D0%B5%2C%20%D0%9C%D0%BE%D1%81%D0%BA%D0%BE%D0%B2%D0%B8%D1%8F!%0A%D0%9C%D1%8B%20%D0%B1%D1%8B%20%D1%85%D0%BE%D1%82%D0%B5%D0%BB%D0%B8%20%D0%B7%D0%B0%D0%BA%D0%B0%D0%B7%D0%B0%D1%82%D1%8C%20%D0%BF%D1%80%D0%BE%D0%BF%D1%83%D1%81%D0%BA%20%D0%BD%D0%B0%20%D0%BF%D1%80%D0%B5%D0%B4%D1%81%D1%82%D0%BE%D1%8F%D1%89%D0%B8%D0%B5%20%D1%81%D0%B1%D0%BE%D1%80%D1%8B!"
                    >
                        оставить заявку на пропуск</a
                    >.
                </p>
                <p>
                    В тексте сообщения необходимо указать полные ФИО
                    посетителей, а также их даты рождения. (Данную процедуру
                    можно пропустить если вы указали эти данные при
                    <router-link to="/register"
                        >регистрации на сборы</router-link
                    >
                    )
                </p>
                <p>
                    Для получения пропуска на КПП бизнес-центра
                    <b>
                        необходимо иметь с собой документ подтверждающий
                        личность</b
                    >. Это может быть паспорт, свидетельство о рождении,
                    водительское удостоверение.
                </p> -->
            </v-col>
            <v-col cols="12" md="6">
                <div style="position:relative;overflow:hidden;"><a href="https://yandex.ru/maps/org/lesnaya_skazka/63577677690/?utm_medium=mapframe&utm_source=maps" style="color:#eee;font-size:12px;position:absolute;top:0px;">Лесная сказка</a><a href="https://yandex.ru/maps/11156/chuvash-republic/category/resort/184106404/?utm_medium=mapframe&utm_source=maps" style="color:#eee;font-size:12px;position:absolute;top:14px;">Санаторий в Чувашской Республике</a><a href="https://yandex.ru/maps/11156/chuvash-republic/category/summer_camp/184106418/?utm_medium=mapframe&utm_source=maps" style="color:#eee;font-size:12px;position:absolute;top:28px;">Детский лагерь отдыха в Чувашской Республике</a><iframe src="https://yandex.ru/map-widget/v1/-/CCUNM0EdOC" width="560" height="400" frameborder="1" allowfullscreen="true" style="position:relative;"></iframe></div>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12" class="mb-0 pb-0">
                <h2>Стоимость участия в сборах:</h2>
                <p>
                    В данную стоимость входить посещение 3 групп, а также
                    участие в практике под руководством тренеров ТСК «Московия».
                </p>
            </v-col>
            <!-- <v-col cols="6" class="pt-0 mt-0">
                <ul>
                    <li>
                        2.500 руб/в день с человека 2 программы;
                    </li>
                    <li>
                        2.200 руб/в день с человека 1 программа.
                    </li>
                </ul>
            </v-col> -->
            <v-col cols="6" class="pt-0 mt-0">
                <ul>
                    <li>
                        26.000 руб/ все дни с человека 2 программы;
                    </li>
                    <li>
                        23.000 руб/ все дни с человека 1 программы.
                    </li>
                    <li>
                        19.000 руб/ все дни для сопровождающих лиц.
                    </li>
                </ul>
            </v-col>
            <v-col cols="12">
                Расценками всех педагогов, принимающих участие на сборах:
                <a href="#" @click.prevent="downloadPriceList">
                    Расценки_педагогов_29.07.2022
                </a>
            </v-col>
        </v-row>
        <v-row class="border-top">
            <v-col cols="12">
                <h2>Остались вопросы касаемо сборов?</h2>
            </v-col>
        </v-row>
        <v-row class="border-bottom">
            <v-col cols="12" sm="6">
                <h5>По организационным вопросам:</h5>
                <p class="mt-5">
                    <v-icon class="mr-3">mdi-phone-outline</v-icon> +7 (919)
                    109-21-04 (Кристина)
                </p>
                <p>
                    <v-icon class="mr-3">mdi-email-outline</v-icon>
                    camp@dancemoscovia.ru
                </p>
            </v-col>
        </v-row>
    </v-container>
</template>
<script>
import PageName from "../components/interface/PageName.vue";
export default {
    data: () => ({
        name: "Контакты",
        tooltip: "Дополнительная информация о предстоящих сборах",
        settings: {
            name: "",
            place: ""
        }
    }),
    methods: {
        loadSettings() {
            axios.get("/api/settings").then(res => {
                this.settings = res.data;
            });
        },
        downloadPriceList() {
            let routeData = this.$router.resolve({
                path: this.settings.coach_price,
            });
            window.open(routeData.href, "_blank");
        }
    },
    components: {
        PageName
    },
    mounted() {
        this.loadSettings();
    }
};
</script>
