<template>
  <div>
      <b-row>
        <b-col md="10"></b-col>
        <b-col md="2">
          <b-button block variant="primary" @click="save">Zapisz</b-button>
        </b-col>
      </b-row>
      <b-row>
        <draggable class="list-group w-100" ghost-class="ghost" :list="items" handle=".handle">
          <div class="list-group-item" v-for="(city, index) in items" :key="index">
            <b-row>
              <b-col lg="2">
                  <b-button type="button" variant="primary" block class="handle">
                      <b-icon-arrows-move></b-icon-arrows-move>
                  </b-button>
              </b-col>
              <b-col lg="10">
                  <span>{{ city.name }}</span>
              </b-col>
            </b-row>
          </div>
        </draggable>
      </b-row>
  </div>
</template>

<script>
    import draggable from 'vuedraggable'
    export default {
        props : ['route', 'cities', 'csrf'],

        components: {
            draggable
        },

        data: function () {
            return {
                items: []
            }
        },

        created: function() {
            this.items = this.cities
        },

        methods: {
          save() {
            let formData = new FormData()
            formData.append('_method', 'POST')
            formData.append('list', JSON.stringify(this.items))

            axios.post(this.route, formData, {
              headers: {
                'X-CSRF-TOKEN': this.csrf
              }
            })
            .then(res => {
              this.$bvToast.toast('Order is updated', {
                title: 'Sortowanie',
                variant: 'success',
                solid: true
              })
            }).catch(err => {
              this.$bvToast.toast('Error: ' + err.message, {
                title: 'Sortowanie',
                variant: 'danger',
                solid: true
              })
            });
          },
        }
    }
</script>