<template>
  <div>
    <heading class="mb-6">
      Booking Calendar
    </heading>

    <api-selector
      v-if="! loading"
      class="form-control form-select"
      v-model="filters.location"
      resource="locations"
      sort-by="name"
      label="name"
      @selected="loadView(); addLocationQueryParam();"
    />

    <div
      v-if="filters.location"
      class="mt-8"
    >
      <div class="flex">
        <card class="bg-90 flex flex-col items-center justify-center flex-1 flex-no-wrap">
          <h1 class="text-white text-4xl text-90 font-light mb-6">
            {{ title }}
          </h1>
        </card>

        <!-- TODO open on current date -->
        <div width="200px;">
          <date-picker
            inline
            use-utc
            @selected="selectDate"
          />
        </div>
      </div>

      <card>
        <loading-view v-if="loading" />

        <schedule-grid
          v-else
          ref="scheduleGrid"
          v-model="filters.date"
          :rooms="rooms"
          :events="events"
          :time-zone="filters.location.php_tz"
          class="py-6 px-6"
        />
      </card>
    </div>
  </div>
</template>

<script>
import DatePicker from 'vuejs-datepicker';
import moment from 'moment';
import ScheduleGrid from './ScheduleGrid';
import ApiSelector from './ApiSelector';

export default {
  components: {
    DatePicker,
    ApiSelector,
    ScheduleGrid,
  },
  data() {
    return {
      slots: [],
      games: [],
      rooms: [],
      loading: false,
      filters: {
        date: null,
        location: null,
      },
    };
  },
  created() {
    this.filters.date = moment.utc();

    this.addLocationFromQueryParam();
  },
  methods: {
    loadView() {
      this.loading = true;

      Promise.all([
        this.loadRooms(),
        this.loadSlots(),
        this.loadGames(),
      ]).finally(() => {
        this.loading = false;
      });
    },
    selectDate(date) {
      this.loading = true;

      this.filters.date = moment.utc(date);

      Promise.all([
        this.loadSlots(),
        this.loadGames(),
      ])
        .finally(() => {
          this.loading = false;
        });
    },
    addLocationQueryParam() {
      this.$router.push({
        query: {
          location: this.filters.location.slug,
        },
      });
    },
    addLocationFromQueryParam() {
      if (this.locationQueryParam) {
        this.loadLocation(this.locationQueryParam)
          .then(() => {
            this.loadView();
          });
      }
    },
    async loadSlots() {
      this.slots = [];

      return Nova.request()
        .get(`/api/availability/${this.filters.location.slug}?include=room,room.theme&initial_date=${this.filters.date.format('YYYY-MM-DD')}&final_date=${this.filters.date.format('YYYY-MM-DD')}`)
        .then((response) => {
          this.slots = response.data.data;
        })
        .catch(() => {
          this.$toasted.show('We couldn\'t load the games.', {
            type: 'error',
          });
        });
    },
    async loadGames() {
      this.games = [];

      return Nova.request()
        .get(`/api/games?include=room&include=room.theme&filter[date]=${this.filters.date.format('YYYY-MM-DD')}&filter[location]=${this.filters.location.slug}`)
        .then((response) => {
          this.games = response.data.data;
        })
        .catch(() => {
          this.$toasted.show('We couldn\'t load the games.', {
            type: 'error',
          });
        });
    },
    loadRooms() {
      return Nova.request()
        .get(`/api/rooms?filter[location]=${this.filters.location.slug}`)
        .then((response) => {
          this.rooms = response.data.data;
        });
    },
    async loadLocation(slug) {
      return Nova.request()
        .get(`/api/locations/${slug}`)
        .then((response) => {
          this.filters.location = response.data.data;
        });
    },
  },
  computed: {
    title() {
      const date = this.filters.date.format('LL');

      return `${date} (${this.filters.location.name})`;
    },
    events() {
      return [...this.transformedSlots].concat([...this.transformedGames]);
    },
    transformedGames() {
      return [...this.games].map((game) => ({
        resourceId: game.room_id,
        title: game.game_number,
        start: game.slot.location_start,
        end: game.slot.location_available,
        url: `/admin/resources/games/${game.id}`,
        backgroundColor: '#71cc98',
        borderColor: 'transparent',
      }));
    },
    transformedSlots() {
      return [...this.slots].map((slot) => {
        const transformedSlot = {
          resourceId: slot.room_id,
          start: slot.location_start,
          end: slot.location_available,
          borderColor: 'transparent',
        };

        if (slot.schedule_type !== 'recurring_schedules') {
          transformedSlot.url = `/admin/resources/slots/${slot.id}`;
          if (slot.participants > 0) {
            transformedSlot.backgroundColor = '#71CC98';
            transformedSlot.title = `Participants: ${slot.participants}`;
          }
          if (slot.participants === 0 && slot.participants_available === 0) {
            transformedSlot.backgroundColor = '#BF140C';
            transformedSlot.title = 'Blocked Slot';
          }
          if (slot.participants === 0 && slot.participants_available > 0) {
            transformedSlot.backgroundColor = '#1B365D';
            transformedSlot.title = `Available: ${slot.participants_available}`;
          }
        }

        if (slot.schedule_type === 'recurring_schedules') {
          transformedSlot.url = '/admin/resources/recurring-schedules';
          transformedSlot.title = `Available: ${slot.participants_available}`;
          transformedSlot.backgroundColor = '#1B365D';
        }

        return transformedSlot;
      });
    },
    locationQueryParam() {
      return this.$router.currentRoute.query.location;
    },
  },
};
</script>
