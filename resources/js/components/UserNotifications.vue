<template>
   <div>
        <li class="dropdown mt-3 mr-4">
            <a href="#"  data-toggle="dropdown">
               <span><i class="fas fa-bullhorn"></i></span>
            </a>
            <ul class="dropdown-menu notifications">
                <li v-for="notification in notifications" v-if="notifications.length">
                <a :href="notification.data.link" class="dropdown-item" v-text="notification.data.message" @click="markAsRead(notification)"></a>
                </li>
                <li v-if="!notifications.length">You have no new notification</li>
            </ul>
        </li>    
   </div>
</template>


<script>
export default{
    data(){
        return{
            notifications:false
        }
    },
     created(){
        this.fetchNotifications();
    },
    methods:{
    fetchNotifications(){
     axios.get('/'+window.App.user.id + '/notifications')
                  .then(response => this.notifications = response.data);
    },
    markAsRead(notification){
     axios.delete(window.App.user.id+"/notifications/"+notification.id);
    }    
    }
}
</script>


