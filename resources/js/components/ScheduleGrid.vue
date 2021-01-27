<template>
  <full-calendar
    ref="fullCalendar"
    default-view="resourceTimeGridDay"
    :time-zone="timeZone"
    height="auto"
    header=""
    :plugins="calendarPlugins"
    :scheduler-license-key="licenseKey"
    :resources="rooms"
    :events="events"
    min-time="09:00:00"
    max-time="1.00:59:00"
    @hook:mounted="setDate"
  />
</template>

<script>
import FullCalendar from '@fullcalendar/vue'
import resourceTimeGridPlugin from '@fullcalendar/resource-timegrid'

export default {
  components: {
    FullCalendar
  },
  props: {
    value: {
      type: Object,
      default: () => {}
    },
    rooms: {
      type: Array,
      required: true
    },
    events: {
      type: Array,
      required: true
    },
    timeZone: {
      type: String,
      default: 'utc'
    }
  },
  data () {
    return {
      calendarPlugins: [
        resourceTimeGridPlugin
      ]
    }
  },
  methods: {
    render () {
      this.$refs.fullCalendar
        .getApi()
        .render()
    },
    setDate () {
      if (this.isCalendarOnTheWrongDate()) {
        const date = this.value.toDate()

        this.calendar.gotoDate(date)
      }
    },
    isCalendarOnTheWrongDate () {
      const calendarDate = this.calendar.getDate()

      return !moment.utc(calendarDate)
        .isSame(this.value, 'day')
    }
  },
  computed: {
    licenseKey () {
      return Nova.config.fullCalendarLicenseKey
    },
    calendar () {
      return this.$refs.fullCalendar
        ? this.$refs.fullCalendar.getApi()
        : null
    }
  }
}
</script>

<style lang="scss" scoped>
@import '~@fullcalendar/core/main.css';
@import '~@fullcalendar/daygrid/main.css';
@import '~@fullcalendar/timegrid/main.css';
</style>
