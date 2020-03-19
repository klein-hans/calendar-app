<template>
  <div class="container mt-3">
    <alert :message="alertMessage" :isSaved="isSaved"></alert>
    <div class="row">
      <div class="col-lg-4 mt-4">
        <form @submit.prevent="onSubmit">
          <div class="form-group row " v-bind:class="{ 'is-invalid': errors.event_name != null }">
            <label for="event_name" class="control-label col-lg-12 pl-0">Event</label>
            <input 
              type="text" 
              name="event_name" 
              id="event_name" 
              class="col-lg-12 form-control "
              v-bind:class="{ 'is-invalid': errors.event_name != null }"
              v-model="form.event_name">
              <span v-if="errors.event_name != null" class="help-block col-lg-12 text-danger p-0">
                * {{ errors.event_name }}
              </span>
          </div>
          <div class="form-group row " v-bind:class="{ 'is-invalid': errors.start_date != null }">
            <label for="start_date" class="control-label col-lg-12 pl-0">From</label>
            <input 
              type="date" 
              name="start_date" 
              id="start_date"
              class="col-lg-12 form-control "
              v-bind:class="{ 'is-invalid': errors.start_date != null }"
              v-model="form.start_date">
              <span v-if="errors.start_date != null" class="help-block col-lg-12 text-danger p-0">
                * {{ errors.start_date }}
              </span>
          </div>
          <div class="form-group row " v-bind:class="{ 'is-invalid': errors.end_date != null }">
            <label for="end_date" class="control-label col-lg-12 pl-0">To</label>
            <input 
              type="date" 
              name="end_date" 
              id="end_date" 
              class="col-lg-12 form-control "
              v-bind:class="{ 'is-invalid': errors.end_date != null }"
              v-model="form.end_date">
              <span v-if="errors.end_date != null" class="help-block col-lg-12 text-danger p-0">
                * {{ errors.end_date }}
              </span>
          </div>
          <div class="row mb-3 mt-4">
            <div class="col-lg-12 px-0">
              <div v-for="item in days" :key="item.name" class="form-check form-check-inline">
                <input 
                  type="checkbox" 
                  :name="item.name"
                  v-model="item.isChecked"
                  v-bind:id="item.name" 
                  class="form-check-input m-0">
                <label v-bind:for="item.name" class="form-check-label">{{ item.value }}</label>
              </div>
            </div> <!-- end of col-lg-12 -->
          </div> <!-- end of row -->
          <div class="row mt-5">
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </form>
      </div>
      <div class="col-lg-8">
        <FullCalendar defaultView="dayGridMonth" :plugins="calendarPlugins" :events="events" />
      </div>
    </div>
  </div>
</template>

<script>

  import FullCalendar from '@fullcalendar/vue'
  import dayGridPlugin from '@fullcalendar/daygrid'
  import Alert from './Alert.vue'
  import axios from "axios";

  export default {
    components: {
      FullCalendar, // make the <FullCalendar> tag available
      Alert
    },
    data() {
      return {
        calendarPlugins: [ dayGridPlugin ],
        form: {
          event_name: null,
          start_date: null,
          end_date: null,
          days: []
        },
        days: [
          { name: "mon", value: "Mon", isChecked: false},
          { name: "tue", value: "Tue", isChecked: false},
          { name: "wed", value: "Wed", isChecked: false},
          { name: "thu", value: "Thu", isChecked: false},
          { name: "fri", value: "Fri", isChecked: false},
          { name: "sat", value: "Sat", isChecked: false},
          { name: "sun", value: "Sun", isChecked: false},
        ],
        errors: {
          event_name: null,
          start_date: null,
          end_date: null,
        },
        isSaved: false,
        alertMessage: "",
        events: []
      }
    },
    methods: {
      async onSubmit() {
        this.days.map(item => {
          item.isChecked ? this.form.days.push(item.value) : null;
        });
        return await axios.post('api/calendar/store', {
          event_name: this.form.event_name,
          start_date: this.form.start_date,
          end_date: this.form.end_date,
          days: this.form.days,
        })
        .then((res) => {
          if('error' in res.data){
            let error = res.data.error;
            this.errors.event_name = 'event_name' in error ? error.event_name[0] : null;
            this.errors.start_date = 'start_date' in error ? error.start_date[0] : null;
            this.errors.end_date = 'end_date' in error ? error.end_date : null;
          }else{  
            this.getCalendarEvents();
            for(let key in this.errors) this.errors[key] = null;
            for(let key in this.form) this.form[key] = key == 'days' ? [] : null;
            this.days.map(item => {
              return item.isChecked = false;
            });
            this.alertMessage = res.data.message;
            this.isSaved = true;
            setTimeout(() => {
                this.isSaved = false;
            }, 3000);
           }
        })
        .catch((error) => {
          console.log(error);
        });
      },
      getCalendarEvents() {
        this.events = [];
        return axios.get('api/calendar')
        .then((res) => {
          res.data.forEach(item => {
            this.events.push({
              title: item.event_name,
              date: item.event_date,
            })
          });
        })
        .catch((error) => {
          console.log(error);
        });
      },
      check(e) {
        if(e.target.checked){
          this.form.days.push(e.target.value);
        }else{
          let index =  this.form.days.indexOf(e.target.value);
          this.form.days.splice(index, 1);
        }
      }
    },
    created() {
      this.getCalendarEvents();
    }
  }

</script>


<style lang='scss'>
  @import '~@fullcalendar/core/main.css';
  @import '~@fullcalendar/daygrid/main.css';
  .alert-success {
    position: absolute;
    right: 15px;
    z-index: 99;
    width: 330px;
    opacity: 0.95;
  }
  .fc-day-grid-event > .fc-content {
    white-space: normal;
    text-overflow: ellipsis;
    max-height:20px;
  }
  .fc-day-grid-event > .fc-content:hover {
    max-height:none!important; 
  }
</style>