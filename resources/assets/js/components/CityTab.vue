<template>
  <div>
      <b-card no-body>
        <b-tabs pills card>
          <b-tab title="Miasto" active>
            <b-card-text>
              <city
                  :route="route"
                  :media-search-route="mediaSearchRoute"
                  :media-route="mediaRoute"
                  :check-route="checkRoute"
                  :csrf="csrf"
                  :city="city"
              ></city>
            </b-card-text>
          </b-tab>
          <b-tab title="Tłumaczenia" :disabled="!city">
            <b-card-text>
              <translations
                  v-if="city"
                  :route="route"
                  :csrf="csrf"
                  :city="city"
                  :languages="languages"
              ></translations>
            </b-card-text>
          </b-tab>
          <b-tab title="Galeria" :disabled="!city">
            <b-card-text>
              <gallery
                  v-if="city"
                  :route="route"
                  :media-search-route="mediaSearchRoute"
                  :media-route="mediaRoute"
                  :csrf="csrf"
                  :city="city"
              ></gallery>
            </b-card-text>
          </b-tab>
        </b-tabs>
      </b-card>
  </div>
</template>

<script>
    import City from "./City"
    import Translations from "./Translations"
    import Gallery from "./Gallery"
    export default {
        props: {
            city: Object,
            languages: Array,
            csrf: String,
            route: String,
            mediaSearchRoute: String,
            mediaRoute: String,
            checkRoute: String
        },

        components: {
            City,
            Translations,
            Gallery,
        }
    }
</script>

