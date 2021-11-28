<template>
   <div class="row">
          <!-- ./col -->
            <div class="col-lg-3 col-6" v-for="(category,index) in categories" :key="index">
                <!-- small card -->
                <div :class="category.is_active == 1 ? 'small-box bg-success' : 'small-box bg-danger'">
                <div class="inner">
                    <p>{{category.name}}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">
                    Inside Category <i class="fas fa-arrow-circle-right"></i>
                </a>
                </div>
            </div>
        </div>
</template>

<script>
    export default {
         data () {
            return {
            categories: [],
            }
        },
        mounted(){
                this.$Progress.start();
                axios.get("/_bookcafe")
                .then((response) => {
                    console.log(response.data);
                    this.categories = response.data;
                    this.$Progress.finish();
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    }
</script>