<template>
    <v-container>
        <page-name :name="name" :tooltip="tooltip" />
        <v-form ref="form">
            <v-row class="border-bottom">
                <v-col cols="12" md="6">
                    <v-radio-group v-model="member.type" row>
                        <template v-slot:label>
                            Выберите подходящий вам вариант
                        </template>
                        <v-radio value="couple">
                            <template v-slot:label>
                                <div class="ml-2 pt-2">Мы пара</div>
                            </template>
                        </v-radio>
                        <v-radio value="solo">
                            <template v-slot:label>
                                <div class="ml-2 pt-2">Я солист/ка</div>
                            </template>
                        </v-radio>
                    </v-radio-group>
                </v-col>
                <v-col cols="12" md="6">
                    <v-row align="center">
                        <v-col cols="7" class='d-none'>
                            <v-checkbox v-model="member.hotel.status">
                                <template v-slot:label>
                                    <div class="pt-4">
                                        <span v-if="member.type == 'couple'"
                                            >Нам</span
                                        >
                                        <span v-else>Мне </span> нужно
                                        проживание на время проведения сборов
                                    </div>
                                </template>
                            </v-checkbox>
                        </v-col>
                        <v-col cols="12">
                            <v-text-field
                                label="Номер телефона"
                                dense
                                outlined
                                class="pt-5 mt-4"
                                v-model="member.hotel.phone"
                                v-mask="'+7 (###) ###-##-##'"
                                placeholder="+7 (987) 654-32-10"
                                hint="Пожалуйста, укажите ваш номер телефона, чтобы мы могли с вами связаться!"
                                persistent-hint
                            >
                            </v-text-field>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>
            <v-row class="border-bottom pt-4">
                <v-col cols="12" md="3">
                    <v-text-field
                        v-model="member.main[0].name"
                        label="Партнер (Ф.И.О)"
                        outlined
                        dense
                        persistent-hint
                        :hint="member.main[0].hint"
                    >
                    </v-text-field>
                </v-col>
                <v-col cols="12" md="3">
                    <v-text-field
                        v-mask="'##.##.####'"
                        v-model="member.main[0].birthdate"
                        dense
                        outlined
                        label="Дата рождения"
                        prepend-icon="mdi-calendar-range"
                        placeholder="01.01.1970"
                    ></v-text-field>
                </v-col>
                <v-col cols="12" md="2">
                    <v-select
                        label="Категория"
                        v-model="member.category"
                        :items="items"
                        outlined
                        dense
                    ></v-select>
                </v-col>
                <v-col cols="12" md="2">
                    <v-text-field
                        v-model="member.club.name"
                        label="Танцевальный клуб"
                        outlined
                        dense
                    ></v-text-field>
                </v-col>
                <v-col cols="12" md="2">
                    <v-text-field
                        v-model="member.club.city"
                        label="Город"
                        outlined
                        dense
                    ></v-text-field>
                </v-col>
            </v-row>
            <v-row v-if="member.type == 'couple'">
                <v-col cols="12" md="3">
                    <v-text-field
                        v-model="member.main[1].name"
                        label="Партнерша (Ф.И.О)"
                        :hint="member.main[1].hint"
                        persistent-hint
                        outlined
                        dense
                    ></v-text-field>
                </v-col>
                <v-col cols="12" md="3">
                    <v-text-field
                        v-mask="'##.##.####'"
                        v-model="member.main[1].birthdate"
                        dense
                        outlined
                        label="Дата рождения"
                        prepend-icon="mdi-calendar-range"
                        placeholder="01.01.1970"
                    ></v-text-field>
                </v-col>
            </v-row>
            <v-row class="border-bottom">
                <v-col cols="12" md="6" class="d-none">
                    <span class="mb-0 grey-color">Дни участия:</span>
                    <v-row>
                        <v-col
                            cols="2"
                            v-for="(date, index) in camp_dates"
                            :key="`date${index}`"
                        >
                            <v-checkbox
                                v-model="member.dates"
                                :value="date"
                                checked
                                dense
                            >
                                <template v-slot:label>
                                    <div class="pt-2">
                                        {{ date }}
                                    </div>
                                </template>
                            </v-checkbox>
                        </v-col>
                    </v-row>
                </v-col>
                <v-col cols="12" md="6">
                    <span class="grey-color">Выберите тариф сборов:</span>
                    <v-select
                        class="mt-2"
                        v-model="member.tax"
                        :items="tarifs"
                        persistent-hint
                        hint="Детальную информацию по тарифам можно узнать в разделе «Инфо»"
                        outlined
                        dense
                    ></v-select>
                </v-col>
            </v-row>
            <v-row class="border-bottom">
                <v-col cols="12" md="3">
                    <v-checkbox v-model="member.companions">
                        <template v-slot:label>
                            <div class="pt-2">
                                У
                                <span v-if="member.type == 'couple'">нас</span>
                                <span v-else>меня </span> есть сопровождающие
                            </div>
                        </template>
                    </v-checkbox>
                </v-col>
                <v-col cols="12" md="9" v-if="member.companions">
                    <v-row
                        v-for="(companion, index) in member.companions_info"
                        :key="index"
                        class="pt-5"
                    >
                        <v-col cols="11">
                            <v-row>
                                <v-col cols="7">
                                    <v-text-field
                                        placeholder="Ф.И.О."
                                        outlined
                                        dense
                                        v-model="companion.name"
                                        value="companion"
                                        persistent-hint
                                        hint="Укажите имена и даты рождения сопровождающих лиц"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="5">
                                    <v-text-field
                                        v-mask="'##.##.####'"
                                        v-model="companion.birthdate"
                                        dense
                                        outlined
                                        label="Дата рождения"
                                        prepend-icon="mdi-calendar-range"
                                        placeholder="01.01.1970"
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                        </v-col>
                        <v-col cols="1" class="d-flex justify-content-center">
                            <v-icon
                                class="align-self-start"
                                large
                                @click="addNewCompanion"
                                >mdi-plus-circle</v-icon
                            >
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>
            <v-row v-if="loading">
                <v-col cols="12" class="d-flex justify-content-center">
                    <v-progress-circular indeterminate></v-progress-circular>
                </v-col>
            </v-row>
            <v-row v-else class="border-bottom">
                <v-col cols="12" lg="4" md="6">
                    <h5>Педагоги по стандарту:</h5>
                    <v-row
                        align="center"
                        v-for="(coach, index) in coaches.standard"
                        :key="`coach${index}`"
                    >
                        <v-col cols="7">
                            <v-checkbox
                                v-model="coach.checked"
                                :disabled="!!coach.closed"
                            >
                                <template v-slot:label>
                                    <div class="pt-4 mt-2 coach_name">
                                        {{ coach.name }}
                                        <p
                                            class="coach_dates_red"
                                            v-if="coach.comments"
                                        >
                                            {{ coach.comments }}
                                        </p>
                                        <p class="coach_dates_green" v-else>
                                            Все дни
                                        </p>
                                    </div>
                                    <v-tooltip right>
                                        <template
                                            v-slot:activator="{ on, attrs }"
                                        >
                                            <v-icon
                                                v-bind="attrs"
                                                v-on="on"
                                                color="grey lighten-1"
                                                x-small
                                                class="ml-1"
                                            >
                                                mdi-help-circle-outline
                                            </v-icon>
                                        </template>
                                        <span>{{ coach.regalia }}</span>
                                    </v-tooltip>
                                </template>
                            </v-checkbox>
                        </v-col>
                        <v-col cols="5">
                            <v-text-field
                                v-model="coach.taked_hours"
                                :label="
                                    coach.price +
                                        coach.currency +
                                        ' ' +
                                        '(45мин.)'
                                "
                                :disabled="Boolean(!coach.checked)"
                                :hint="getAvailableHours(coach.available_hours)"
                                persistent-hint
                            >
                            </v-text-field>
                        </v-col>
                    </v-row>
                </v-col>
                <v-col cols="12" lg="4" md="6">
                    <h5>Педагоги по латине:</h5>
                    <v-row
                        align="center"
                        v-for="(coach, index) in coaches.latin"
                        :key="`coach${index}`"
                    >
                        <v-col cols="7">
                            <v-checkbox
                                v-model="coach.checked"
                                :disabled="!!coach.closed"
                            >
                                <template v-slot:label>
                                    <div class="pt-4 mt-2 coach_name">
                                        {{ coach.name }}
                                        <p
                                            class="coach_dates_red"
                                            v-if="coach.comments"
                                        >
                                            {{ coach.comments }}
                                        </p>
                                        <p class="coach_dates_green" v-else>
                                            Все дни
                                        </p>
                                    </div>
                                    <v-tooltip right>
                                        <template
                                            v-slot:activator="{ on, attrs }"
                                        >
                                            <v-icon
                                                v-bind="attrs"
                                                v-on="on"
                                                color="grey lighten-1"
                                                x-small
                                                class="ml-1"
                                            >
                                                mdi-help-circle-outline
                                            </v-icon>
                                        </template>
                                        <span>{{ coach.regalia }}</span>
                                    </v-tooltip>
                                </template>
                            </v-checkbox>
                        </v-col>
                        <v-col cols="5">
                            <v-text-field
                                v-model="coach.taked_hours"
                                :disabled="Boolean(!coach.checked)"
                                :label="
                                    coach.price +
                                        coach.currency +
                                        ' ' +
                                        '(45мин.)'
                                "
                                :hint="getAvailableHours(coach.available_hours)"
                                persistent-hint
                            >
                            </v-text-field>
                        </v-col>
                    </v-row>
                </v-col>
                <v-col cols="12" lg="4" md="6">
                    <h5>Педагоги по 10т:</h5>
                    <v-row
                        align="center"
                        v-for="(coach, index) in coaches.ten"
                        :key="index"
                    >
                        <v-col cols="7">
                            <v-checkbox
                                v-model="coach.checked"
                                :disabled="!!coach.closed"
                            >
                                <template v-slot:label>
                                    <div class="pt-4 mt-2 coach_name">
                                        {{ coach.name }}
                                        <p
                                            class="coach_dates_red"
                                            v-if="coach.comments"
                                        >
                                            {{ coach.comments }}
                                        </p>
                                        <p class="coach_dates_green" v-else>
                                            Все дни
                                        </p>
                                    </div>
                                    <v-tooltip right>
                                        <template
                                            v-slot:activator="{ on, attrs }"
                                        >
                                            <v-icon
                                                v-bind="attrs"
                                                v-on="on"
                                                color="grey lighten-1"
                                                x-small
                                                class="ml-1"
                                            >
                                                mdi-help-circle-outline
                                            </v-icon>
                                        </template>
                                        <span>{{ coach.regalia }}</span>
                                    </v-tooltip>
                                </template>
                            </v-checkbox>
                        </v-col>
                        <v-col cols="5">
                            <v-text-field
                                v-model="coach.taked_hours"
                                :disabled="Boolean(!coach.checked)"
                                :label="
                                    coach.price +
                                        coach.currency +
                                        ' ' +
                                        '(45мин.)'
                                "
                                :hint="getAvailableHours(coach.available_hours)"
                                persistent-hint
                            >
                            </v-text-field>
                        </v-col>
                    </v-row>
                    <h5>Педагоги по ОФП и хореографии:</h5>
                    <v-row
                        align="center"
                        v-for="(coach, index) in coaches.ofp"
                        :key="index"
                    >
                        <v-col cols="7">
                            <v-checkbox
                                v-model="coach.checked"
                                :disabled="!!coach.closed"
                            >
                                <template v-slot:label>
                                    <div class="pt-4 mt-2 coach_name">
                                        {{ coach.name }}
                                        <p
                                            class="coach_dates_red"
                                            v-if="coach.comments"
                                        >
                                            {{ coach.comments }}
                                        </p>
                                        <p class="coach_dates_green" v-else>
                                            Все дни
                                        </p>
                                    </div>
                                    <v-tooltip right>
                                        <template
                                            v-slot:activator="{ on, attrs }"
                                        >
                                            <v-icon
                                                v-bind="attrs"
                                                v-on="on"
                                                color="grey lighten-1"
                                                x-small
                                            >
                                                mdi-help-circle-outline
                                            </v-icon>
                                        </template>
                                        <span>{{ coach.regalia }}</span>
                                    </v-tooltip>
                                </template>
                            </v-checkbox>
                        </v-col>
                        <v-col cols="5">
                            <v-text-field
                                v-model="coach.taked_hours"
                                :disabled="Boolean(!coach.checked)"
                                :label="
                                    coach.price +
                                        coach.currency +
                                        ' ' +
                                        '(55мин.)'
                                "
                                :hint="getAvailableHours(coach.available_hours)"
                                persistent-hint
                            >
                            </v-text-field>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12">
                    <h5>Комментарии к заявке:</h5>
                    <v-textarea
                        v-model="member.comments"
                        clearable
                        clear-icon="mdi-close-circle"
                        label="Данное поле можно пропустить"
                        outlined
                        dense
                        hint="Мы обязательно постараемся все учесть!"
                    >
                    </v-textarea>
                </v-col>
            </v-row>
            <v-row class="d-flex" align="center">
                <v-col cols="12" sm="6">
                    <h5>Итоговая стоимость участия в сборах:</h5>
                    <v-divider></v-divider>
                    <ul class="">
                        <li>
                            Тариф сборов: {{ this.member.camp_cost.tax }}
                            <i v-if="member.type == 'solo'">соло</i>
                            <i v-if="member.type == 'couple'">в паре</i>
                        </li>
                        <li>Дни участия: {{ this.member.dates.join(", ") }}</li>
                        <li class="border-bottom">
                            Групповые уроки на сборах:
                            <b> {{ this.member.camp_cost.camp_price }} руб.</b>
                        </li>
                        <li>
                            Уроки с педагогами:
                            <ul>
                                <li
                                    v-for="coach in member.coaches"
                                    :key="coach.id"
                                >
                                    {{ coach.name }} * {{ coach.taked_hours }} =
                                    {{ coach.price * coach.taked_hours }}
                                    <span v-if="coach.currency == 'euro'"
                                        >euro;</span
                                    >
                                    <span v-if="coach.currency == 'руб'"
                                        >руб;</span
                                    >
                                </li>
                            </ul>
                        </li>
                        <li class="border-bottom">
                            Инд. уроки на сборах:
                            <b>
                                <span
                                    v-if="
                                        this.member.camp_cost.coaches_price
                                            .rub !== 0
                                    "
                                    >{{
                                        this.member.camp_cost.coaches_price.rub
                                    }}руб</span
                                >
                                <span
                                    v-if="
                                        this.member.camp_cost.coaches_price
                                            .rub !== 0 &&
                                            this.member.camp_cost.coaches_price
                                                .euro !== 0
                                    "
                                    >,</span
                                >
                                <span
                                    v-if="
                                        this.member.camp_cost.coaches_price
                                            .euro !== 0
                                    "
                                    >{{
                                        this.member.camp_cost.coaches_price
                                            .euro
                                    }}euro</span
                                >
                            </b>
                        </li>

                        <li>
                            Итого: <b>{{ this.member.camp_cost.total }}</b>
                        </li>
                    </ul>
                    <h5>Обращаем ваше внимание, что в стоимость, указанную выше не входит проживание для сопровождающих. 50% предоплата до 05.07. Оплата оставшейся половины за сборы производится строго в первый день!</h5>
                </v-col>
                <v-col cols="12" sm="6">
                    <v-text-field
                        v-model="member.email"
                        label="email@mail.ru"
                        prepend-icon="mdi-email"
                        hint="Введите ваш E-mail адрес и незабудьте указать номер телефона выше, что бы мы могли с вами связаться, если возникнут изменения!"
                        persistent-hint
                        dense
                        outlined
                    ></v-text-field>
                    <v-btn
                        block
                        color="primary"
                        @click.prevent="sendForm"
                        :disabled="this.sendFormButton"
                        :loading="this.sendFormButton"
                        >Отправить</v-btn
                    >
                </v-col>
                <v-col cols="4" lg="2"> </v-col>
            </v-row>
        </v-form>
    </v-container>
</template>

<script>
import PageName from "../components/interface/PageName.vue";

import axios from "axios";
import moment from "moment";
moment.locale("ru");

// phone number replacer
export default {
    data: () => ({
        name: "Регистрация на сборы",
        tooltip: "Для регистрации заполните все необходимые поля",

        loading: true,
        sendFormButton: false,
        coaches: {
            standard: [],
            latin: [],
            ofp: [],
            ten: []
        },
        menu: {
            male_birthdate: false,
            female_birthdate: false
        },
        member: {
            type: "couple",
            main: [
                { name: "", birthdate: null },
                { name: "", birthdate: null }
            ],
            category: "Юниоры-1",
            tax: "«Две программы»",
            club: { name: "", city: "" },
            hotel: { status: false, phone: "" },
            dates: [],
            companions: false,
            companions_info: [{ name: "", birthdate: null, menu: false }],
            comments: "",
            email: "",
            coaches: [],
            camp_cost: {
                tax: "«Две программы»",
                camp_price: 0,
                coaches_price: {
                    rub: 0,
                    euro: 0
                },
                total: 0
            }
        },
        items: ["Дети", "Юниоры-1", "Юниоры-2", "Молодежь", "Взрослые"],
        camp_dates: [],
        tarifs: [],
        moscovia_key: ""
    }),
    mounted() {
        this.loadCoaches();
        this.loadSettings();
        this.calcCampCost();
    },
    methods: {
        addNewCompanion() {
            this.member.companions_info.push({ name: "" });
        },
        loadCoaches() {
            axios.get("/api/coaches").then(res => {
                this.coaches.standard = res.data.filter(
                    item => item.program.toLowerCase() == "стандарт"
                );
                this.coaches.latin = res.data.filter(
                    item => item.program.toLowerCase() == "латина"
                );
                this.coaches.ofp = res.data.filter(
                    item => item.program.toLowerCase() == "офп"
                );
                this.coaches.ten = res.data.filter(
                    item => item.program.toLowerCase() == "10т"
                );

                setTimeout(() => {
                    this.loading = false;
                }, 500);
            });
        },
        loadSettings() {
            axios.get("api/settings").then(res => {
                this.camp_dates = res.data.dates_array.split(", ");
                this.tarifs = res.data.tarifs.split(", ");
                this.member.dates = this.camp_dates;
            });
        },
        sendForm() {
            this.sendFormButton = true;

            // send this member's object to register controller
            axios
                .post("/api/send-email", this.member, {
                    headers: {
                        "Content-type": "application/json"
                    }
                })
                .then(res => {
                    if (res.data.status) {
                        console.log(res.data.content);
                        this.$notification["success"](
                            "Ваша заявка была успешно отправлена!"
                        );
                        setTimeout(() => {
                            this.$router.push({ name: "index" });
                        }, 3000);
                    } else {
                        this.sendFormButton = false;
                        this.$notification["error"](res.data.message);
                    }
                })
                .catch(err => {
                    console.log(err.response.data);
                });
        },
        getAvailableHours(hours) {
            if (hours < 15) {
                return "Осталось " + hours + " уроков";
            } else {
                return "";
            }
        },
        calcCampCost() {
            this.member.camp_cost.total = 0;
            if (this.member.tax === "«Две программы»") {
                if (this.camp_dates.length == this.member.dates.length) {
                    this.member.camp_cost.camp_price = 26000;
                } else {
                    this.member.camp_cost.camp_price =
                        2600 * this.member.dates.length;
                }
            } else if (this.member.tax === "«Одна программа»") {
                if (this.camp_dates.length == this.member.dates.length) {
                    this.member.camp_cost.camp_price = 23000;
                } else {
                    this.member.camp_cost.camp_price =
                        2300 * this.member.dates.length;
                }
            } else if (this.member.tax === "«Без групп»") {
                if (this.camp_dates.length == this.member.dates.length) {
                    this.member.camp_cost.camp_price = 0;
                } else {
                    this.member.camp_cost.camp_price =
                        0 * this.member.dates.length;
                }
            }
            if (this.member.type == "couple") {
                this.member.camp_cost.camp_price *= 2;
            }

            this.member.camp_cost.coaches_price.rub = 0;
            this.member.camp_cost.coaches_price.euro = 0;

            this.member.coaches.forEach(coach => {
                if (coach.currency == "руб") {
                    this.member.camp_cost.coaches_price.rub +=
                        coach.price * coach.taked_hours;
                }
            });
            this.member.coaches.forEach(coach => {
                if (coach.currency == "euro") {
                    this.member.camp_cost.coaches_price.euro +=
                        coach.price * coach.taked_hours;
                }
            });
            this.member.camp_cost.total =
                this.member.camp_cost.camp_price +
                this.member.camp_cost.coaches_price.rub;

            if (this.member.camp_cost.coaches_price.euro !== 0) {
                this.member.camp_cost.total +=
                    "руб + " +
                    this.member.camp_cost.coaches_price.euro +
                    "euro";
            } else {
                this.member.camp_cost.total += "руб";
            }
        }
    },
    computed: {
        formattedDate_1() {
            return this.member.main[0].birthdate
                ? moment(this.member.main[0].birthdate).format("L")
                : "";
        },
        formattedDate_2() {
            return this.member.main[1].birthdate
                ? moment(this.member.main[1].birthdate).format("L")
                : "";
        }
    },
    watch: {
        "member.tax": {
            handler() {
                this.member.camp_cost.tax = this.member.tax;
                this.calcCampCost();
            }
        },
        "member.type": {
            handler() {
                this.calcCampCost();
            }
        },
        "member.dates": {
            handler() {
                this.calcCampCost();
            }
        },
        "member.main.0.name": {
            handler() {
                if (this.member.type == "solo") {
                    this.member.main["1"]["name"] = "";
                }

                axios
                    .post("/api/getCorrectRecordPrice", this.member.main)
                    .then(res => {
                        console.log(res.data);
                        if (!res.data.status) {
                            return;
                        }
                        this.member.main[0].name = res.data.members[0]["name"];

                        this.member.main[0].birthdate = moment(
                            res.data.members[0]["birthdate"]
                        ).format("L");

                        if (res.data.members.length > 1) {
                            this.member.main[1].name =
                                res.data.members[1]["name"];
                            this.member.main[1].birthdate = moment(
                                res.data.members[1]["birthdate"]
                            ).format("L");
                        }

                        this.member.category = res.data.members[0]["age"];
                        this.member.club.name = "Московия";
                        this.member.club.city = "Москва";

                        // fill new prices to coach
                        res.data.coaches.forEach(item => {
                            let coach = {};
                            coach = this.coaches.standard.find(
                                ({ name }) => name === item.name
                            );

                            if (!coach) {
                                coach = this.coaches.latin.find(
                                    ({ name }) => name === item.name
                                );
                            }

                            if (!coach) {
                                coach = this.coaches.ten.find(
                                    ({ name }) => name === item.name
                                );
                            }

                            if (!coach) {
                                coach = this.coaches.ofp.find(
                                    ({ name }) => name === item.name
                                );
                            }

                            if (!coach) {
                                return;
                            }

                            coach.price = item.price;
                        });
                    });
            }
        },
        coaches: {
            handler() {
                let coaches = [];


                coaches.push(
                    ...this.coaches.standard.filter(function(coach) {
                        if (coach.taked_hours != "0") {
                            return coach.checked;
                        }
                    })
                );
                coaches.push(
                    ...this.coaches.latin.filter(function(coach) {
                        if (coach.taked_hours != "0") {
                            return coach.checked;
                        }
                    })
                );
                coaches.push(
                    ...this.coaches.ofp.filter(function(coach) {
                        if (coach.taked_hours != "0") {
                            return coach.checked;
                        }
                    })
                );
                coaches.push(
                    ...this.coaches.ten.filter(function(coach) {
                        if (coach.taked_hours != "0") {
                            return coach.checked;
                        }
                    })
                );
                this.member.coaches = coaches;

                this.calcCampCost();
            },
            deep: true
        }
    },
    components: {
        PageName
    }
};
</script>

<style scoped>
p,
span.grey-color {
    color: rgba(0, 0, 0, 0.6);
}
p.coach_dates_red {
    font-size: 0.9rem;
    font-weight: bold;
    color: darkred;
}
p.coach_dates_green {
    font-size: 0.9rem;
    font-weight: bold;
    color: darkgreen;
}

span {
    font-size: 1rem;
}
.coach_name {
    font-size: 1.05rem;
}
ul {
    list-style-type: none;
}
</style>
