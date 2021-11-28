<template>
    <div>
           <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">{{requests.length}}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <!-- Message Start -->
            There are {{requests.length}} Book requests from Members.
            <!-- Message End -->
          <div class="dropdown-divider"></div>
            <router-link to="/book-request" class=" dropdown-item dropdown-footer">
                  <p>See Detail</p>
            </router-link>
        </div>
      </li>
    </div>
</template>

<script>
    export default {
         data () {
            return {
                requests : []
            }
        },
        created(){
            axios.get("/_bookcafe/member/request")
            .then((response) => {
                this.requests = response.data;
            })
            .catch((error) => {
                console.log(error);
            });
        },
    }
</script>