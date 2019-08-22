<template>
   <div>
        <li class="dropdown mt-3 mr-4">
            <a href="#"  data-toggle="dropdown">
               <span v-if="!notifications.length"><i class="fas fa-bullhorn"></i></span>
               <span v-if="notifications.length"><i class="fas fa-bullhorn icon-color"></i></span>

            </a>
            <ul class="dropdown-menu notifications">
                <li v-for="notification in notifications" :key="notification.id" v-if="notifications.length">
    <a class="dropdown-item" :href="notification.data.link"  @click.prevent="markAsRead(notification)">
   <span>{{getPostBody(notification)}}</span>
    </a>
</li>
                <li v-if="!notifications.length" class="mt-2 mr-4 ml-4">No new notifications</li>
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
        fetchNotifications() {
                axios.get('/'+window.App.user.id + '/notifications')
                  .then(response => this.notifications = response.data);
            },
            markAsRead(notification){
                axios.delete('/'+window.App.user.id+"/notifications/"+notification.id)
                .then(response => {
                    this.fetchNotifications();
                    document.location.replace(response.data.link);
                    console.log(response.data.link);
                });
            },
    getPostBody (notification) {
    let body = this.stripTags(notification.data.message);

    return body.length > 35 ? body.substring(0, 35) + '...' : body;           
    },

        stripTags (text) {
            return text.replace(/(<([^>]+)>)/ig, '');
        }
    }
    
}
</script>


