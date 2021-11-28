<template>
<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Register My Own Book</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" @submit="formSubmit" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="form-group" style="margin-bottom: 100px; ">
                      <div class="input-group">
                          <div id="preview">
                              <div class="custom-file">
                                <input type="file" class="custom-file-input" id="e" @change="onPreviewFrontSelected" required>
                                <label class="custom-file-label" for="aaa" >Front Cover Upload</label>
                              </div>
                            <img :src="front_url" id="frontCover">
                          </div>

                          <div class="img_container">
                              <div class="c">
                                   <img class="c-image" :src="previewFrontImgShow == '' ? 'images/preview.png' : previewFrontImgShow">
                              </div>
                              <div class="custom-control custom-checkbox mt-4">
                                  <a @click="previewFront" class="btn btn-info btn-sm">Preview Front-Cover</a>
                              </div>
                          </div>
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:100px;">
                      <div class="input-group">
                          <div id="preview">
                              <div class="custom-file">
                                <input type="file" class="custom-file-input" id="backCoverFile" @change="onPreviewBackSelected" required>
                                <label class="custom-file-label" for="backCoverFile" >Back Cover Upload</label>
                              </div>
                                <img :src="back_url" id="backCover">
                          </div>
                       
                        <div class="img_container">
                              <div class="c">
                                   <img class="c-image" :src="previewBackImgShow == '' ? 'images/preview.png' : previewBackImgShow">
                              </div>
                              <div class="custom-control custom-checkbox mt-4">
                                  <a @click="previewBack" class="btn btn-info btn-sm">Preview Back-Cover</a>
                              </div>
                          </div>

                      </div>
                  </div>
                  <div class="form-group">
                    <label for="name">Book Name</label>
                    <input type="text" v-model="name" class="form-control" id="name" placeholder="Enter Book Name" required >
                  </div>
                    <div class="form-group ">
                        <label for="type">Which Category You Want To Store?</label>
                        <select name="category" id="" class="form-control" v-model="category" required>
                            <option v-for="(category,index) in categories" :key="index" :value="category.id">{{category.name}}</option>
                        </select>
                    </div>
                  <div class="form-group">
                    <label for="desc">Tell us For Your Opinion About This Book</label>
                    <textarea v-model="desc" id="desc" class="form-control" required></textarea>
                  </div>

                  <!-- <div class="form-group ">
                    <label for="exampleInputFile">Upload Book Cover (* You can upload Multiple Images)</label>
                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" id="multipleCover" @change="onFileSelected"  multiple>
                          <label class="custom-file-label" for="multipleCover" >Choose file</label>
                        </div>
                        <div class="input-group-append" v-if="!selectedFiles.length">
                          <span class="input-group-text" id="">No Image</span>
                        </div>
                        <div class="input-group-append" v-else>
                          <span class="input-group-text" id="" style="background: green; color: #fff">Got {{selectedFiles.length}} Files Selected</span>
                        </div>
                      </div>
                  </div> -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Request To Admin</button>
                </div>
              </form>
            </div>
</template>

<script>
    export default {
            data () {
            return {
                name: '',
                category: null,
                desc: '',
                front_url: '',
                front_file: null,
                back_url: '',
                back_file: null,
                selectedFiles : [],
                categories : [],
                front_img: '',
                back_img: '',
                test: null,
                previewFrontImgShow: '',
                previewBackImgShow: '',

            }
        },
        mounted(){
          this.front_img = $("#frontCover").cropme({
              container: {
                width: 500,
                height: 400
              },
              viewport: {
                width: 210,
                height: 320,
                border: {
                  enable: true,
                  width: 5,
                  color: '#007bff'
                }
              }
            });
          this.back_img = $("#backCover").cropme({
              container: {
                width: 500,
                height: 400
              },
              viewport: {
                width: 210,
                height: 320,
                border: {
                  enable: true,
                  width: 5,
                  color: '#007bff'
                }
              }
            });
        },
        created(){
                this.$Progress.start();
                axios.get("/_bookcafe/get")
                .then((response) => {
                    this.categories = response.data;
                    this.$Progress.finish();
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        methods: {
          handle(e){
              var f = e.target.files[0];
              let reader = new FileReader();
              let that = this;
              reader.onload = function (e) {
                // that.images.push(e.target.result);
                that.image = e.target.result;
              }
              reader.readAsDataURL(f);
          },
            onFileSelected(e){
                let getFiles = e.target.files;
                if(!getFiles.length){
                    return false;
                }
                for(let i=0; i< getFiles.length; i++){
                    this.selectedFiles.push(getFiles[i]);
                }
            },
            onPreviewFrontSelected(e){
              this.front_file = e.target.files[0];
              this.front_url = URL.createObjectURL(this.front_file);

            },
            onPreviewBackSelected(e){
              this.back_file = e.target.files[0];
              this.back_url = URL.createObjectURL( this.back_file);
            },
            getSubmitForm: function(imageData){

                const data = new FormData();
                const json_data = JSON.stringify({
                    name: this.name,
                    category: this.category,
                    desc: this.desc,
                });
                data.append('data',json_data);
                for(var key in imageData){
                  data.append(key, imageData[key]);
                }
                axios.post('/_bookcafe/request',data)
                    .then(response => {
                    swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: response.data.message,
                            showConfirmButton: false,
                            timer: 3000
                    });
                    this.name = '';
                    this.category = '';
                    this.desc = '';
                    this.$router.push('/my-pending-list');
                    this.$Progress.finish();
                    for(let a=0; a<this.selectedFiles.length; a++){
                        this.selectedFiles.splice(a, this.selectedFiles.length);
                    }
                    })
                    .catch(error => {
                        console.log(error)
                    })
            },
            formSubmit: function(e){
                e.preventDefault();
                var that = this;
                  this.$Progress.start();
                    that.front_img.cropme('crop').then( function(frontImg) {
                        that.back_img.cropme('crop').then( function(backImg) {
                         that.resizeImage(frontImg, 100, 100, function(frontImg02){
                          that.resizeImage(backImg, 100, 100, function(backImg02){
                           that.getSubmitForm({
                            front_file : frontImg,
                            back_file : backImg,
                            front_small : frontImg02,
                            back_small : backImg02
                           });
                          });
                         });
                         return ;
                        });
                    });
                return ;
            },
            resizeImage: function(base64Str, maxWidth = 100, maxHeight = 100, callBack){
              let img = new Image()
              img.src = base64Str
              img.onload = () => {
                let canvas = document.createElement('canvas')
                const MAX_WIDTH = maxWidth
                const MAX_HEIGHT = maxHeight
                let width = img.width
                let height = img.height

                if (width > height) {
                  if (width > MAX_WIDTH) {
                    height *= MAX_WIDTH / width
                    width = MAX_WIDTH
                  }
                } else {
                  if (height > MAX_HEIGHT) {
                    width *= MAX_HEIGHT / height
                    height = MAX_HEIGHT
                  }
                }
                canvas.width = width
                canvas.height = height
                let ctx = canvas.getContext('2d')
                ctx.drawImage(img, 0, 0, width, height)
                callBack(canvas.toDataURL());
              }
            },
            previewFront(){
              const that = this;
              if(that.front_url != ''){
                  that.front_img.cropme('crop').then( function(frontImg) {
                     var byteString = atob(frontImg.split(',')[1]);
                      var mimeString = frontImg.split(',')[0].split(':')[1].split(';')[0];
                      var ab = new ArrayBuffer(byteString.length);
                      var ia = new Uint8Array(ab);
                      for (var i = 0; i < byteString.length; i++) {
                          ia[i] = byteString.charCodeAt(i);
                      }
                      // write the ArrayBuffer to a blob, and you're done
                      //    var BlobBuilder = window.WebKitBlobBuilder || window.MozBlobBuilder;
                      // var bb = new BlobBuilder();
                      try {
                        const blob = new Blob([ab], {type: mimeString});
                        const blobUrl = URL.createObjectURL(blob);
                        that.previewFrontImgShow = blobUrl;
                        return ;
                          // return new Blob([ab], {type: mimeString});
                      } catch (e) {
                          // The BlobBuilder API has been deprecated in favour of Blob, but older
                          // browsers don't know about the Blob constructor
                          // IE10 also supports BlobBuilder, but since the `Blob` constructor
                          //  also works, there's no need to add `MSBlobBuilder`.
                          var BlobBuilder = window.WebKitBlobBuilder || window.MozBlobBuilder;
                          var bb = new BlobBuilder();
                          bb.append(ab);
                           that.previewFrontImgShow = bb.getBlob(mimeString);
                          return ;
                      }
               });
              }
               return ;
          },
          previewBack(){
                const that = this;
                  if(that.back_url != ''){
                      that.back_img.cropme('crop').then( function(backImg) {
                        var byteString = atob(backImg.split(',')[1]);
                          var mimeString = backImg.split(',')[0].split(':')[1].split(';')[0];
                          var ab = new ArrayBuffer(byteString.length);
                          var ia = new Uint8Array(ab);
                          for (var i = 0; i < byteString.length; i++) {
                              ia[i] = byteString.charCodeAt(i);
                          }
                          // write the ArrayBuffer to a blob, and you're done
                          //    var BlobBuilder = window.WebKitBlobBuilder || window.MozBlobBuilder;
                          // var bb = new BlobBuilder();
                          try {
                            const blob = new Blob([ab], {type: mimeString});
                            const blobUrl = URL.createObjectURL(blob);
                            that.previewBackImgShow = blobUrl;
                            return ;
                              // return new Blob([ab], {type: mimeString});
                          } catch (e) {
                              // The BlobBuilder API has been deprecated in favour of Blob, but older
                              // browsers don't know about the Blob constructor
                              // IE10 also supports BlobBuilder, but since the `Blob` constructor
                              //  also works, there's no need to add `MSBlobBuilder`.
                              var BlobBuilder = window.WebKitBlobBuilder || window.MozBlobBuilder;
                              var bb = new BlobBuilder();
                              bb.append(ab);
                              that.previewBackImgShow = bb.getBlob(mimeString);
                              return ;
                          }
                      });
                  }
               return ;
          }
        }
    }
</script>
<style scoped>
#preview {
 background: red;
 margin: 0 auto;
}
.img_container img {
  background-color: rgba(16,46,72,0.6);
    background-blend-mode: multiply;
    height: 350px;
    /* width: 210px;
    height: 320px; */
}

.img_container{
  padding: 1rem;
  margin: 0 auto;
}

.c {
  position: relative;
  /* width: 90%; */
  max-width: 210px;
  height: 350px;
  margin: auto;
  overflow: hidden;
}

.c .c-overlay {
  background: rgba(00,45,114,0.8);
  position: absolute;
  width: 100%;
  left: 0;
  top: 0;
  bottom: 0;
  right: 0;
  opacity: 0;
  -webkit-transition: all 0.4s ease-in-out 0s;
  -moz-transition: all 0.4s ease-in-out 0s;
  transition: all 0.4s ease-in-out 0s;
}

.c:hover .c-overlay{
  opacity: 1;
  cursor: pointer;
}

.c-image{
  width: 100%;
}

.c-details {
  position: absolute;
  text-align: center;
  width: 100%;
  top: 50%;
}

.c-details .c-title{
  color: #fff;
  font-weight: 500;
  letter-spacing: 0.15em;
  margin-bottom: 0.5em;
  text-transform: uppercase;
}
.c:hover .c-title {
  -webkit-transform: translate3d(-1rem, 0, 0);
          transform: translate3d(-1rem, 0, 0);
}

.c .c-title {
  display: inline-block;
  position: relative;
  transition: all 300ms ease-out;
  will-change: transform;
}

</style>