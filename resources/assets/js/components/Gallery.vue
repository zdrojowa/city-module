<template>
  <div>
      <b-row>
        <b-col md="8"></b-col>
          <b-col md="2">
              <selector
                  extensions="jpg,jpeg,png,3gp,3g2,asf,wmv,avi,divx,evo,f4v,flv,mp4,mpg,mpeg"
                  @media-selected="add"
                  :route="mediaSearchRoute"
                  :media-route="mediaRoute"
              ></selector>
          </b-col>
        <b-col md="2">
          <b-button block variant="primary" @click="save">Zapisz</b-button>
        </b-col>
      </b-row>
      <b-row>
        <draggable class="list-group w-100" ghost-class="ghost" :list="items" handle=".handle">
          <div class="list-group-item" v-for="(item, index) in items" :key="index">
            <b-row>
              <b-col lg="2">
                  <b-button type="button" variant="primary" block class="handle">
                      <b-icon-arrows-move></b-icon-arrows-move>
                  </b-button>
                  <b-button type="button" @click="remove(index)" variant="danger" block>
                      <b-icon-trash></b-icon-trash>
                  </b-button>
              </b-col>
              <b-col lg="10">
                  <file-view-selector
                      label="Media"
                      :id="'gallery-' + index"
                      extensions="jpg,jpeg,png,3gp,3g2,asf,wmv,avi,divx,evo,f4v,flv,mp4,mpg,mpeg"
                      @media-changed="change(index, $event)"
                      :route="mediaSearchRoute"
                      :media-route="mediaRoute"
                      :show="false"
                      :link="true"
                      :file="item"
                  ></file-view-selector>
              </b-col>
            </b-row>
          </div>
        </draggable>
      </b-row>
  </div>
</template>

<script>
    import draggable from 'vuedraggable'
    import Selector from './../../../../../../../vendor/zdrojowa/media-module/resources/assets/js/components/Selector'
    import FileViewSelector from './../../../../../../../vendor/zdrojowa/media-module/resources/assets/js/components/FileViewSelector'
    export default {
        props : ['route', 'mediaSearchRoute', 'mediaRoute', 'csrf', 'city'],

        components: {
            draggable,
            FileViewSelector,
            Selector
        },

        data: function () {
            return {
                items: []
            }
        },

        created: function() {
          if ('gallery' in this.city) {
            this.items = this.city.gallery
          }
        },

        methods: {
          remove(index) {
            this.items.splice(index, 1)
          },

          change(index, $event) {
              if ($event === null) {
                  this.items.splice(index, 1)
              } else {
                  this.items[index] = {id: $event.file._id, type: $event.type}
              }
          },

          add(file) {
            this.items.push({id: file.file._id, type: file.type})
          },

          save() {
            let formData = new FormData()
            formData.append('_method', 'PUT')
            formData.append('gallery', JSON.stringify(this.items))

            axios.post(this.route, formData, {
              headers: {
                'X-CSRF-TOKEN': this.csrf
              }
            })
            .then(res => {
              this.$bvToast.toast('Gallery is updated', {
                title: 'Galeria',
                variant: 'success',
                solid: true
              })
            }).catch(err => {
              this.$bvToast.toast('Error: ' + err.message, {
                title: 'Galeria',
                variant: 'danger',
                solid: true
              })
            });
          },
        }
    }
</script>