<template>
    <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                    <router-link to="/admin/rent-request"><i class="fas fa-arrow-left"></i> </router-link>
                    <div style="width: 10px; display: inline-block;"></div>
                    {{bookName}}
                </h3>
                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Member Name</th>
                      <th>Start Date</th>
                      <th>End Date</th>
                      <th>Rent Days</th>
                    </tr>
                  </thead>
                  <tbody>
                        <tr v-for="(rentInfo,index) in rentInfos" :key="index">
                                <td> {{index + 1}}</td>
                                <td> {{rentInfo.about_member.name}} </td>
                                <td>  {{rentInfo.start_date}} </td>
                                <td>  {{rentInfo.return_date}} </td>
                                <td>
                                    <!-- <button v-on:click="getDiffDays($event,rentInfo.start_date,rentInfo.return_date)" :value="index"  data_at="dd">
                                        Count Day  {{checkVal == index ? diffDay : ''}}
                                    </button> -->
                                    {{rentInfo.return_date.replace(/-|\s/g,"") - rentInfo.start_date.replace(/-|\s/g,"")  }} Days
                                </td>
                                <td class="project-actions">
                                    <button class="btn btn-success btn-sm" @click="saveChange('confirm',index,rentInfo.id)">
                                        Confirm
                                    </button>
                                    <button class="btn btn-danger btn-sm" @click="saveChange('reject',index,rentInfo.id)">
                                        Reject
                                    </button>
                                </td>
                        </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
     
            </div>
            <!-- /.card -->
          </div>
        </div>
    </div>
</template>

<script>
    export default {
         data () {
            return {
                proId : this.$route.params.id,
                rentInfos: [],
                checkVal: null,
                diffDay: null,
                bookName: ''
            }
        },
        mounted(){
            this.getMemberList(this.proId);
        },
        methods: {
            getMemberList: function(id){
                axios.get('/_bookcafe/admin/rent-sort-detail/'+id).then(response => {
                  this.rentInfos = response.data;
                  var getFirstOne = response.data[0];
                  this.bookName = getFirstOne.about_book.name;
                })
                .catch(error => {
                    console.log(error)
                })
            },
            getDiffDays: function(e,startDate,returnDate){
                    var syear = startDate.substring(0, 4);
                    var smonth = startDate.substring(5, 7);
                    var sday = startDate.substring(8, 10);
                    var eyear = returnDate.substring(0, 4);
                    var emonth = returnDate.substring(5, 7);
                    var eday = returnDate.substring(8, 10);

                    var a = moment([syear, smonth, sday]);
                    var b = moment([eyear, emonth, eday]);
                    var diffDay = a.diff(b, 'days'); // Difference Days between Range
                     this.checkVal = e.target.value;
                     this.diffDay = diffDay;
            },
            axiosPost: function(status,index,rentId){
                axios.post("/_bookcafe/admin/save-rent-request",{
                    id : rentId,
                    type: status
                })
                .then((response) => {
                    if(response.data.success == 'confirm'){
                        swal.fire('Confirmation Done', response.data.message, 'success');
                        this.$router.push('/admin/rent-request');
                    }else{
                        swal.fire('Rejection Done', response.data.message, 'success');
                    }
                     this.rentInfos.splice(index,1);
                })
                .catch((error) => {
                    console.log(error);
                });
            },
            saveChange: function(status,index,rentId){
                if(status == 'confirm'){
                    this.confirmAlert(status,index,rentId);
                }else{
                    this.rejectAlert(status,index,rentId);
                }
            },
            confirmAlert: function(status,index,rentId){
                swal.fire({
                    title: 'Are you sure?',
                    text: 'This Book will be rented',
                    type: 'info',
                    showCancelButton: true,
                    confirmButtonText: 'Confirm',
                    cancelButtonText: 'No',
                    showCloseButton: true,
                    showLoaderOnConfirm: true
                    }).then((result) => {
                    if(result.value) {
                       this.axiosPost(status,index,rentId);
                    }
                })
            },
            rejectAlert: function(status,index,rentId){
                    swal.fire({
                    title: 'Are you sure?',
                    text: 'This Book will be rejected by you',
                    type: 'info',
                    showCancelButton: true,
                    confirmButtonText: 'Reject',
                    cancelButtonText: 'No',
                    showCloseButton: true,
                    showLoaderOnConfirm: true
                    }).then((result) => {
                    if(result.value) {
                       this.axiosPost(status,index,rentId);
                    }
                })
            }
        }
    }
</script>