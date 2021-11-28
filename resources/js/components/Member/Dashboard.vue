<template>

  <section class="content">
      <div class="container-fluid">
          <!-- Info boxes -->
            <div class="jumbotron">
              <h5 class="display-5">Hello, {{datas.name}}!</h5>
              <p class="lead">{{datas.email}}</p>
            </div>
          <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">My Published Book</span>
                  <span class="info-box-number">
                  {{datas.authBookPublished}}
                  </span>
                </div>
              </div>
              </div>
              <!-- /.info-box -->
                <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">My Pending Book</span>
                  <span class="info-box-number">
                  {{datas.authBookPending}}
                  </span>
                </div>
              </div>
               </div>
              <!-- /.info-box -->
                <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">My Current Rent Book</span>
                  <span class="info-box-number">
                  {{datas.myCurrentRentBooks}}
                  </span>
                </div>
              </div>
               </div>
              <!-- /.info-box -->
                <div class="col-12 col-sm-6 col-md-3">
               <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">My Over Date Book</span>
                  <span class="info-box-number">
                  {{datas.myOverDateBooks}}
                  </span>
                </div>
              </div>
               </div>
              <!-- /.info-box -->
                <div class="col-12 col-sm-6 col-md-3">
               <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">My Rented Book</span>
                  <span class="info-box-number">
                  {{datas.myRentedBooks}}
                  </span>
                </div>
              </div>
               </div>
              <!-- /.info-box -->
            </div>
          </div>
      </div>
  </section>
</template>

<script>
    export default {
         data () {
            return {
               datas : []
            }
        },
        created(){
             this.getData();
        },
        methods: {
            getData: function(){
                axios.get('/_bookcafe/member/dashboard').then(response => {
                  this.datas = response.data;
                  console.log(response.data);
                  this.$Progress.finish();
                })
                .catch(error => {
                    console.log(error)
                })
            }
        }
    }
</script>