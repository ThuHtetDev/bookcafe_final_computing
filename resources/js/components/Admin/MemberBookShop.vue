<template>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
          <div class="col-lg-3 col-6" v-for="(data,index) in datas" :key="index">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner" style="text-overflow: ellipsis; white-space: nowrap; overflow: hidden;">
                <p>{{data.name}}</p>
                <p>{{data.email}}</p>
                <h4><span style="font-size: 14px">Own Books </span>[{{data.ownBookCount}}]</h4>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
                <router-link :to="{ name: 'BookShopDetail', params: { id: data.id  } }" class="small-box-footer" >
                        <span style="color: white"> Detail </span>
                        <i class="fas fa-arrow-circle-right"></i>
                </router-link>
            </div>
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
        mounted(){
          this.$Progress.start();
          this.getData();
        },
        methods: {
               getData: function(){
                axios.get('/_bookcafe/admin/book-shop').then(response => {
                  this.datas = response.data;
                  this.$Progress.finish();
                })
                .catch(error => {
                    console.log(error)
                })
            }
        }
    }
</script>