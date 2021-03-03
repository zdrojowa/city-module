<template>
  <div>
      <b-card no-header class="mb-2">
          <b-table striped hover :responsive="true" :items="items" :fields="fields">
              <template #cell(actions)="row">
                  <b-button :href="edit(row.item)" variant="primary">
                      <b-icon-pencil></b-icon-pencil>
                  </b-button>
                  <b-button @click="remove(row.item)" variant="danger">
                      <b-icon-trash></b-icon-trash>
                  </b-button>
              </template>
          </b-table>
      </b-card>
  </div>
</template>

<script>
    export default {
        props : ['route', 'removeRoute', 'editRoute', 'csrf'],

        data() {
            return {
                fields: [
                    {
                        key: 'order',
                        sortable: true,
                        variant: 'info',
                        label: '#'
                    },
                    {
                        key: 'name',
                        sortable: true,
                        label: 'Nazwa'
                    },
                    {
                        key: 'actions',
                        label: ''
                    }
                ],
                items: []
            }
        },

        created: function() {
            this.get()
        },

        methods: {

            get() {
                let self = this
                axios.get(this.route)
                .then(function(response) {
                    self.items = response.data
                }).catch(function(error) {
                    console.log(error)
                })
            },

            remove(item) {
                let self = this
                this.$bvModal.msgBoxConfirm('Czy jesteś pewny?', {
                    title: 'Usunąć miasto?',
                    size: 'sm',
                    buttonSize: 'sm',
                    okVariant: 'danger',
                    okTitle: 'Tak',
                    cancelTitle: 'Nie',
                    footerClass: 'p-2',
                    hideHeaderClose: false,
                    centered: true
                })
                .then(value => {
                    if (value) {
                        let route = self.removeRoute.replace('id', item.id)
                        axios.delete(route, {
                            headers: {
                                'X-CSRF-TOKEN': self.csrf
                            }
                        })
                        .then(function(response) {
                            self.get()
                        }).catch(function(error) {
                            console.log(error)
                        })
                    }
                })
                .catch(err => {
                    console.log(err)
                })
            },

            edit(item) {
                return this.editRoute.replace('id', item.id)
            }
        },
    }
</script>

