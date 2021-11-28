import VueRouter from 'vue-router';

  let routes  = [
    // ! Admin Dashboard
    { path: '/dashboard', component: require('./components/Admin/Dashboard.vue').default },
    { path: '/book-shop', component: require('./components/Admin/MemberBookShop.vue').default },
    { path: '/book-shop/:id',name:'BookShopDetail', component: require('./components/Admin/MemberBookShopDetail.vue').default },

    { path: '/users/memberlist', component: require('./components/Admin/MemberList.vue').default },
    { path: '/users/adminlist', component: require('./components/Admin/AdminList.vue').default },
    { path: '/users/add-member', component: require('./components/Admin/AddMember.vue').default },
    { path: '/users/add-member-social', component: require('./components/Admin/AddMemberSocial.vue').default },
    { path: '/users/add-admin', component: require('./components/Admin/AddAdmin.vue').default },
    { path: '/category', component: require('./components/Admin/Category.vue').default },
    { path: '/add-category', component: require('./components/Admin/AddCategory.vue').default },
    { path: '/book-request', component: require('./components/Book/AdminBookRequest.vue').default },  //  Book Request
    { path: '/book-request-detail/:id', name:'BookRequestDetail', component: require('./components/Book/BookRequestDetail.vue').default },  // Book Request Detail
    // Admin Book List
    { path: '/admin/book-list', component: require('./components/Admin/BookList.vue').default },
    { path: '/admin/book-list-detail/:id',name:'AdminBookDetail', component: require('./components/Admin/BookListDetail.vue').default },
    { path: '/admin/rent-request', component: require('./components/Admin/RentRequest.vue').default },
    { path: '/admin/rent-sort-detail/:id', name: 'RentSortDetail', component: require('./components/Admin/RentSortDetail.vue').default },
    { path: '/admin/return-list', component: require('./components/Admin/ReturnList.vue').default },

    // ! User Dashboard
    { path: '/add-book', component: require('./components/Member/AddBook.vue').default },
    { path: '/my-book-list', component: require('./components/Book/OwnBookList.vue').default },
    { path: '/my-pending-list', component: require('./components/Member/BookPending.vue').default },
     // Member Book List
     { path: '/book-list', component: require('./components/Member/BookList.vue').default },
     { path: '/book-detail/:id', name:'BookDetail', component: require('./components/Member/BookListDetail.vue').default },
     { path: '/setting', component: require('./components/Member/Setting.vue').default },
     { path: '/queue-list', component: require('./components/Member/QueueList.vue').default },
     { path: '/current-rent-list', component: require('./components/Member/RentList.vue').default },
     { path: '/rented-list', component: require('./components/Member/Rented.vue').default },
     { path: '/my-dashboard', component: require('./components/Member/Dashboard.vue').default },
     { path: '/book-edit/:id',name:'BookEdit', component: require('./components/Member/BookEdit.vue').default },
  ]
  const router = new VueRouter({
    mode: 'history',
    linkActiveClass: 'active',
    routes // short for `routes: routes`
  })

  export default router;