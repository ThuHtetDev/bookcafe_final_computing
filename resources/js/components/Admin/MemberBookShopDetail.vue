<template>
    <div>
        <h3 class="card-title">
                <router-link to="/book-shop"><i class="fas fa-arrow-left"></i> </router-link>
                <div style="width: 10px; display: inline-block;"></div>
                <small>{{member.name}}'s own books</small>
        </h3>
     <section class="content"> 
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row" v-if="isExit">
          <div class="col-12" v-for="(bookInfo,index) in datas" :key="index">
                <div class="box">
                    <div class="product-img">
                    <img v-bind:src="'/storage/user_'+member.id+'/book/front_cover/'+bookInfo.book.front_cover" width="250" alt="" />
                    </div>
                    <div class="product-info">
                    <h1>{{bookInfo.book.name}} <span style="font-size: 14px; color: green;">[ {{bookInfo.book.status}} ]</span></h1>
                    <p class="price"><span style="font-size: 14px;">Rented Times </span>[{{bookInfo.rented}}]</p>
                    <p class="description">{{bookInfo.book.description}}</p>
                    </div>
                </div>
                <hr>
          </div>
        </div>
        <div v-else>
            <p style="margin: 0 auto; text-align:center; font-size: 30px">{{member.name}} has no own book yet</p>
        </div>
      </div>
     </section>
    </div>
</template>

<script>
    export default {
         data () {
            return {
                proId : this.$route.params.id,
                datas : [],
                member: {},
                isExit: null,
            }
        },
        mounted(){
            this.getMemberInfo(this.proId);
        },
        methods: {
            getMemberInfo: function(id){
                axios.get('/_bookcafe/admin/book-shop/'+id).then(response => {
                  this.datas = response.data[0];
                  this.isExit = response.data.isBookExist;
                  this.member  = response.data.member;
                })
                .catch(error => {
                    console.log(error)
                })
            }
        }
    }
</script>
<style scoped>
.card-img-overlay {
  background-color: rgba(#000, 0.4);
}
@media only screen and (max-device-width: 480px) {
	 .box {
		 margin: 20px;
	}
	 .product-info {
		 margin: 20px;
	}
}
 .container {
	 display: flex;
	 justify-content: center;
	 margin-top: 50px;
	 font-family: 'Open Sans', sans-serif;
}
 .box {
	 width: 700px;
	 border-radius: 10px;
	 box-shadow: 0 0 30px 0 #999;
}
 .product-img {
	 float: left;
	 margin-top: 20px;
	 transition: all 0.5s linear;
}
 .product-img:hover {
	 transform: scale(1.03);
}
 .product-info {
	 float: right;
	 margin-top: 20px;
     margin-right: 40px;
     width: 350px;
}
 h1 {
	 margin-bottom: 50px;
	 font-weight: bold;
	 font-size: 2.5em;
	 color: #333;
	 font-family: 'Archivo Black', sans-serif;
}
 .price {
	 margin-top: -40px;
	 font-size: 35px;
	 font-weight: bolder;
	 color: coral;
}
 .description {
	 margin-top: -20px;
	 margin-right: 10px;
	 font-weight: bold;
	 color: #555;
}
 .color {
	 margin-top: 25px;
	 outline: none;
	 border: 2px solid #999;
	 padding: 5px;
	 border-radius: 5px;
}
 .qty {
	 margin-top: 25px;
	 outline: none;
	 border: 2px solid #999;
	 padding: 5px;
	 border-radius: 5px;
}
 button {
	 margin-top: 10px;
	 background: #333;
	 font-size: 1em;
	 letter-spacing: 0.1em;
	 text-decoration: none;
	 color: #fff;
	 padding: 15px 30px;
	 border: 0;
	 border-radius: 10px;
	 transition: all 0.3s linear;
	 margin-left: 50px;
}
 button:hover {
	 background: #666;
}
 
</style>