<template>
    <div>
          <li class="nav-item">
            <router-link to="/my-dashboard" class="nav-link">
              <i class="nav-icon fa fa-home" aria-hidden="true"></i>
                  <p>
                    {{ trans('member.dashboard') }}
                  </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/add-book" class="nav-link">
              <i class="nav-icon fas fa-plus"></i>
                  <p>
                    {{ trans('member.register_book') }}
                  </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/book-list" class="nav-link">
                <i class="nav-icon fas fa-book"></i>
                  <p>{{ trans('member.book_newfeed') }} </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/my-book-list" class="nav-link">
            <i class="nav-icon fa fa-user-secret" aria-hidden="true"></i>
                  <p>
                   {{ trans('member.my_book') }}
                  </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/my-pending-list" class="nav-link">
            <i class="nav-icon fas fa-money-check"></i>
              <p>
                 {{ trans('member.my_pending') }}
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/queue-list" class="nav-link">
                <i class="nav-icon fas fa-clock"></i>
                  <p>  {{ trans('member.my_queue') }}</p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/current-rent-list" class="nav-link">
                <i class="nav-icon fas fa-list-ul"></i>
                  <p>  {{ trans('member.my_current_rent') }}</p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/rented-list" class="nav-link">
                <i class="nav-icon fas fa-calendar-check"></i>
                  <p>  {{ trans('member.my_rented_book') }}</p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/setting" class="nav-link">
                <i class="nav-icon fa fa-cogs" aria-hidden="true"></i>
                  <p>  {{ trans('member.setting') }}</p>
            </router-link>
          </li>
    </div>
</template>

<script>
    export default {
         data () {
            return {

            }
        },
        created(){
        },
        methods:{

        }
    }
</script>