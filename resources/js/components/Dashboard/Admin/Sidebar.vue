<template>
    <div>
          <li class="nav-item">
            <router-link to="/dashboard" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
                  <p> {{ trans('admin.dashboard') }} </p>
            </router-link>
          </li>
          <li class="nav-item">
                <router-link to="/book-shop" class="nav-link">
                <i class=" nav-icon fa fa-user" aria-hidden="true"></i>
                  <p> {{ trans('admin.member_book_shop') }} </p>
                </router-link>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                 {{ trans('admin.user_management') }} 
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/users/memberlist" class="nav-link">
                <i class=" nav-icon fa fa-user" aria-hidden="true"></i>
                  <p> {{ trans('admin.member_manage') }} </p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/users/adminlist" class="nav-link">
                <i class="nav-icon fa fa-user" aria-hidden="true"></i>
                  <p> {{ trans('admin.admin_manage') }} </p>
                </router-link>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-list" aria-hidden="true"></i>
              <p>
                {{ trans('admin.category') }} 
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/category" class="nav-link">
                    <i class="nav-icon fa fa-book" aria-hidden="true"></i>
                      <p> {{ trans('admin.category_list') }} </p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/add-category" class="nav-link">
                <i class="nav-icon fas fa-plus"></i>
                  <p> {{ trans('admin.add_category') }} </p>
                </router-link>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <router-link to="/admin/book-list" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
                  <p> {{ trans('admin.book_newfeed') }} </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/book-request" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
                  <p> {{ trans('admin.member_book_request') }} </p>
                  <!-- <span class="right badge badge-danger">{{requests.length}}</span> -->
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/admin/rent-request" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
                  <p> {{ trans('admin.rent_request') }} </p>
            </router-link>
          </li>
           <li class="nav-item">
            <router-link to="/admin/return-list" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
                  <p> {{ trans('admin.return_list') }} </p>
            </router-link>
          </li>
    </div>
</template>

<script>
    export default {
         data () {
            return {
              requests: []
            }
        },
        created(){
            this.getBookRequests();
        },
        methods: {
          getBookRequests:function(){
            axios.get("/_bookcafe/member/request")
            .then((response) => {
                this.requests = response.data;
            })
            .catch((error) => {
                console.log(error);
            });
          }
        }
    }
</script>