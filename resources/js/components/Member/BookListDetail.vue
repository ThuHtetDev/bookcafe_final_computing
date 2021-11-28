<template>
    <div>
            <h3 class="card-title" v-if="notFound">
                 <a href="javascript:history.go(-1)"> <i class="fas fa-arrow-left"></i> </a>
                 <div style="width: 10px; display: inline-block;"></div>
                 <small>Not Found This Page</small>
          </h3>
        <div v-else>
          <h3 class="card-title">
                 <a href="javascript:history.go(-1)"> <i class="fas fa-arrow-left"></i> </a>
                 <div style="width: 10px; display: inline-block;"></div>
                 <small>{{detailBooks.name}}</small>
            </h3>
                <div class="card card-primary card-outline">
                       <div class="row" v-if="detailBooks.front_cover != null && detailBooks.back_cover != null">
                          <div class="col-lg-3 col-12 text-center">
                              <div class="inner" @click="showFrontImg()">
                                <img class="img-fluid fit-image" v-bind:src="'/storage/user_'+detailBooks.user_id+'/book/front_cover/'+detailBooks.front_cover">
                          
                              </div>
                               <vue-easy-lightbox
                                  :visible="visible"
                                  :imgs="imgs"
                                  :index="index"
                                  @hide="handleHide"
                                ></vue-easy-lightbox>
                          </div>
                           <div class="col-lg-3 col-12 text-center">
                                <div class="inner" @click="showBackImg()">
                                    <img class="img-fluid fit-image" v-bind:src="'/storage/user_'+detailBooks.user_id+'/book/back_cover/'+detailBooks.back_cover" >
                                </div>
                          </div>
                      </div>
                        <hr>
                        <h3 class="profile-username text-center">{{detailBooks.name}}
                          </h3>
                        <ul class="list-group list-group-unbordered mb-3" style="padding: 0px 200px;">
                          <li class="list-group-item">
                            <b>Queue Members</b> <a class="float-right">{{rentList.length > 0 ? rentList.length : 'No one'}}</a>
                          </li>
                          <li class="list-group-item">
                            <b>Book ISBN</b> <a class="float-right">{{detailBooks.isbn}}</a>
                          </li>
                          <li class="list-group-item">
                            <b>Book Category</b> <a class="float-right">{{category.name}}</a>
                          </li>
                          <li class="list-group-item">
                            <b>Description</b> <p class="float-right">{{detailBooks.description}}</p>
                          </li>
                          <li class="list-group-item">
                            <b>Current Status</b> <a class="float-right">Published</a>
                          </li>
                          <li class="list-group-item">
                            <b>Book Registerd Date</b> <a class="float-right">{{detailBooks.created_at}}</a>
                          </li>
                          <li class="list-group-item">
                            <b>Book Published Date</b> <a class="float-right" >{{detailBooks.updated_at}}</a>
                          </li>
                        </ul>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                          Rent This Book
                        </button>
                      <!-- Modal -->
                      <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLongTitle">Rent Information</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <!-- :disabled-date="disabledBeforeTodayAndAfterAWeek" -->
                              <date-picker v-model="range" range lang="en" format="YYYY-MM-dd"
                              :disabled-date="(date) => checkDisableDates(date)"
                              :multiple="true"
                              confirm></date-picker>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                              <button type="button" class="btn btn-primary"  data-dismiss="modal" @click="rentRequest(detailBooks.id)">Rent Request</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    <!-- Model End -->
                      </div>
                  <!-- /.card-body -->
          </div>
    </div>
</template>

<script>
window.checkState = false;

import DatePicker from 'vue2-datepicker';
import VueEasyLightbox from 'vue-easy-lightbox'

    export default {
      components: {
        DatePicker
      },
        data() {
            return {
                proId : this.$route.params.id,
                detailBooks: [],
                notFound : false,
                category: [],
                rentList: [],
                range: [],
                isSuccess: false,
                start: null,
                end:null,
                realReturnDate: null,
                visible: false,
                index: 0, 
                imgs: [],
                disabledDates : []
            }
        },
        created(){
            this.getBookDetail(this.proId);
        },
        methods: {
          checkDisableDates(date){
            if(date < new Date(new Date().setHours(0, 0, 0, 0))) return true;
            let _date = parseInt(moment(date).format('YYYY-MM-DD').split('-').join(''));
            checkState = false;
            this.disabledDates.forEach(function(dates){
              if(_date >= dates[0] && _date <=  dates[1]){
                if(dates[2] != ''){
                   if(_date >= dates[0] && _date <=  dates[2]){
                      checkState = true;
                   }
                }else{
                  checkState = true;
                }
                // checkState = true;
                return ;
              }
            });
            return checkState;
          },
          showFrontImg (index) {
              this.imgs  = [
                  '/storage/user_'+this.detailBooks.user_id+'/book/front_cover/'+this.detailBooks.front_cover,
              ];
            this.index = index
            this.visible = true
          },
          showBackImg (index) {
              this.imgs  = [
                  '/storage/user_'+this.detailBooks.user_id+'/book/back_cover/'+this.detailBooks.back_cover,
              ];
            this.index = index
            this.visible = true
          },
          showImgs (index,detailBooks,image){
              this.imgs  = [
                  '/storage/user_'+detailBooks.user_id+'/book/inner_images/'+image.img_path,
              ];
            this.index = index
            this.visible = true
          },
          handleHide () {
            this.visible = false
          },
          getRent(data){
            return moment(data).format().substring(0, 10);
          },
          disabledBeforeTodayAndAfterAWeek(date) {
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            // return [date < today || date > new Date(today.getTime() + 7 * 24 * 3600 * 1000), date < today || date > new Date(today.getTime() + 14 * 24 * 3600 * 1000)];
            var date1 = new Date(today.getTime() + 0 * 24 * 3600 * 1000)
            var date2 = new Date(today.getTime() + 7 * 24 * 3600 * 1000)

            var date3 = new Date(today.getTime() + 10 * 24 * 3600 * 1000)
            var date4 = new Date(today.getTime() + 17 * 24 * 3600 * 1000)
            return date < date1 || date > date2
          },
          diffDays: function(){
            var startDate = moment(this.range[0]).format().substring(0, 10);
            var returnDate = moment(this.range[1]).format().substring(0, 10);
              var syear = startDate.substring(0, 4);
              var smonth = startDate.substring(5, 7);
              var sday = startDate.substring(8, 10);
              var eyear = returnDate.substring(0, 4);
              var emonth = returnDate.substring(5, 7);
              var eday = returnDate.substring(8, 10);

              var a = moment([syear, smonth, sday]);
              var b = moment([eyear, emonth, eday]);
              var d = a.diff(b, 'days') // Difference Days between Range
          },
          rentRequest: function(bookId){
              this.$Progress.start();
              this.isSuccess = false;
            if(this.range.length > 0){
               var startDate = moment(this.range[0]).format().substring(0, 10);
                var returnDate = moment(this.range[1]).format().substring(0, 10);
                let data = {
                  bookId: bookId,
                  start_date : startDate,
                  return_date: returnDate
                }
                axios.post('/_bookcafe/rent-request',data)
                  .then(response => {
                    this.$router.push('/book-list');
                    swal.fire('Congratulations', 'Thank you for rent book', 'success');
                    this.$Progress.finish();
                })
                  .catch(error => {
                    console.log(error)
                })
            }else{
                 swal.fire('Required', 'Please Check Date', 'error');
            }
          },
          getBookDetail: function(id){
              this.$Progress.start();
              axios.get('/_bookcafe/member/book/detail/'+id).then(response => {
                  if(response.data.message){
                    this.notFound = true;
                  }else{
                    this.notFound = false;
                  }
                  this.detailBooks = response.data;
                  this.category = response.data.category;
                  this.rentList = response.data.rent_books;
                  var dateList = this.rentList;
                  for(var i=0; i < this.rentList.length; i++){
                    this.start = dateList[i].start_date;
                    this.end = dateList[i].return_date;
                    this.realReturnDate = dateList[i].real_return_date;
                    this.disabledDates.push([
                      parseInt(dateList[i].start_date.split('-').join('')),
                      parseInt(dateList[i].return_date.split('-').join('')),
                      dateList[i].real_return_date != null ? parseInt(dateList[i].real_return_date.split('-').join('')) : ''
                    ]);
                  }
                  this.$Progress.finish();
              })
              .catch(error => {
                  console.log(error)
              })
          },
        }
    }
</script>
