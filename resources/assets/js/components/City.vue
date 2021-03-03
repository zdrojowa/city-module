<template>
    <div>
        <b-row>
            <b-col md="10"></b-col>
            <b-col md="2">
                <b-button block variant="primary" @click="save">Zapisz</b-button>
            </b-col>
        </b-row>
        <b-row>
            <b-col>
                <b-form-group
                    label="Nazwa"
                    description="To pole musi być unikalne"
                >
                    <b-form-input
                        v-model="name"
                        type="text"
                        placeholder="Wpisz nazwę"
                        :state="nameState"
                        required
                    ></b-form-input>
                </b-form-group>
            </b-col>
        </b-row>
        <b-row>
            <b-col>
                <file-view-selector
                    label="Zdjęcie"
                    id="city-file-view-selector"
                    extensions="jpg,jpeg,png"
                    :route="mediaSearchRoute"
                    :media-route="mediaRoute"
                    @media-changed="changeMedia"
                    :show="false"
                    :link="false"
                    :file="image"
                ></file-view-selector>
            </b-col>
        </b-row>
    </div>
</template>

<script>
    import FileViewSelector from './../../../../../../../vendor/zdrojowa/media-module/resources/assets/js/components/FileViewSelector'
    export default {
        props : ['csrf', 'route', 'city', 'mediaSearchRoute', 'mediaRoute', 'checkRoute'],
        components: {
            FileViewSelector
        },

        data() {
            return {
                name: '',
                nameState: null,
                image: null,
                gallery: []
            }
        },

        created() {
            if (this.city) {
                this.name  = this.city.name
                this.image = this.city.image
            }
        },

        methods: {
            check: function() {
                let route = this.checkRoute + '?name=' + this.name
                if (this.city) {
                    route += '&id=' + this.city.id
                }
                axios.get(route)
                .then(res => {
                    this.nameState = res.data
                }).catch(err => {
                    console.log(err)
                })
            },

            changeMedia(file) {
                if (file === null) {
                    this.image = null
                } else {
                    this.image = {id: file.file._id, type: file.type}
                }
            },

            save() {
                if (this.nameState) {
                    let formData = new FormData()
                    formData.append('_method', this.city ? 'PUT' : 'POST')
                    formData.append('name', this.name)
                    formData.append('image', JSON.stringify(this.image))

                    axios.post(this.route, formData, {
                        headers: {
                            'X-CSRF-TOKEN': this.csrf
                        }
                    })
                        .then(res => {
                            window.location = res.data.redirect
                        }).catch(err => {
                        console.log(err);
                    });
                }
            },
        },

        watch: {
            name() {
                if (!this.name.length) {
                    this.nameState = false
                } else {
                    this.check()
                }
            }
        }
    }
</script>
