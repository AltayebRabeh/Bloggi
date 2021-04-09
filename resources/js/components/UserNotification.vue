<template>
    <li class="shopcart">
        <a class="cartbox_active" href="#">
            <span class="product_qun" v-if="unreadCount > 0">{{unreadCount}}</span>
        </a>
        <!-- Start Shopping Cart -->
        <div class="block-minicart minicart__active">
            <div class="minicart-content-wrapper" v-if="unreadCount > 0">
                <div class="single__items">
                    <div class="miniproduct">

                        <div class="item01 d-flex mt--20" v-for="item in unread" :key="item.id">
                            <div class="thumb">
                                <a :href="`edit-comment/${item.data.id}`" @click="readNotifications(item)"><img src="assets/comment.png"  width="50" height="50" :alt="`${ item.data.post_title }`"></a>
                            </div>
                            <div class="content">
                                <a :href="`edit-comment/${item.data.id}`">You have a new comment on your post: {{ item.data.post_title }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Shopping Cart -->
    </li>
</template>

<script>
    export default {
        data: function() {
            return {
                read: {},
                unread: {},
                unreadCount: 0
            }
        },
        created: function() {
            this.getNotifications();

            let userId = $('meta[name="userId"]').attr('content');
            Echo.private('App.User.' + userId)
                .notififcation((notification) => {
                    this.unread.unshift(notification);
                    this.unreadCount++;
                });
        },
        methods: {
            getNotifications() {
                axios.get('user/notifications/get').then(res => {
                    this.read = res.data.read;
                    this.unread = res.data.unread;
                    this.unreadCount = res.data.unread.length;
                }).catch(error => Exception.handle(error))
            },
            readNotifications(notifaication) {
                axios.post('user/notifications/read', {id: notifaication.id}).then(res => {
                    this.unread.splice(notifaication, 1);
                    this.read.push(notifaication);
                    this.unreadCount--;
                })
            }
        }
    }
</script>
