<template>
    <div>
        <b-row>
            <b-col md="10"></b-col>
            <b-col md="2">
                <b-button block variant="primary" @click="save">Zapisz</b-button>
            </b-col>
        </b-row>
        <div v-for="lang in languages" :key="lang.value">
            <b-row>
                <b-col lg="6">
                    <b-form-group
                        :label="'Tytuł (' + lang.value + ')'"
                    >
                        <b-form-input
                            v-model="titles[lang.value]"
                            type="text"
                            placeholder="Wpisz tytuł"
                        ></b-form-input>
                    </b-form-group>
                </b-col>
                <b-col lg="6">
                    <b-form-group
                        :label="'Etykieta (' + lang.value + ')'"
                    >
                        <b-form-input
                            v-model="labels[lang.value]"
                            type="text"
                            placeholder="Wpisz etykietę"
                        ></b-form-input>
                    </b-form-group>
                </b-col>
            </b-row>
            <b-row>
                <b-col>
                    <b-form-group
                        :label="'Opis (' + lang.value + ')'"
                    >
                        <b-form-textarea
                            v-model.lazy="descriptions[lang.value]"
                            rows="6"
                        ></b-form-textarea>
                    </b-form-group>
                </b-col>
            </b-row>
        </div>
    </div>
</template>

<script>
    export default {
        props : ['csrf', 'route', 'city', 'languages'],

        data() {
            return {
                titles: {},
                labels: {},
                descriptions: {}
            }
        },

        created() {
            this.titles       = this.city.titles ? this.city.titles : {}
            this.labels       = this.city.labels ? this.city.labels : {}
            this.descriptions = this.city.descriptions ? this.city.descriptions : {}

            this.languages.forEach(lang => {
                if (!(lang.value in this.titles)) {
                    this.titles[lang.value] = ''
                }
                if (!(lang.value in this.labels)) {
                    this.labels[lang.value] = ''
                }
                if (!(lang.value in this.descriptions)) {
                    this.descriptions[lang.value] = ''
                }
            })
        },

        methods: {
            save() {
                let formData = new FormData()
                formData.append('_method', 'PUT')
                formData.append('titles', JSON.stringify(this.titles))
                formData.append('labels', JSON.stringify(this.labels))
                formData.append('descriptions', JSON.stringify(this.descriptions))

                axios.post(this.route, formData, {
                    headers: {
                        'X-CSRF-TOKEN': this.csrf
                    }
                })
                .then(res => {
                    this.$bvToast.toast('Translations are updated', {
                        title: 'Tłumaczenia',
                        variant: 'success',
                        solid: true
                    })
                }).catch(err => {
                    this.$bvToast.toast('Error: ' + err.message, {
                        title: 'Tmaczenia',
                        variant: 'danger',
                        solid: true
                    })
                });
            }
        }
    }
</script>
