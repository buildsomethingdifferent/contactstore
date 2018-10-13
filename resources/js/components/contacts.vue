<template>
    <div>
        <h1>Contacts</h1>
        <form action="#" @submit.prevent="edit ? updateContact(contact.id): createContact()">
            <div class="form-group">
                <label for="">Name:</label>
                <input type="text" v-model="contact.name" name="name" class="form-control">
            </div>
            <div class="form-group">
                <label for="">Email:</label>
                <input type="text" v-model="contact.email" name="email" class="form-control">
            </div>
            <div class="form-group">
                <label for="">Phone:</label>
                <input type="text" v-model="contact.phone" name="phone" class="form-control">
                </div>
            <div class="form-group">
                <button type="submit" v-show="!edit" name="btn btn-primary"> Create Contact</button>
                <button type="submit" v-show="edit" name="btn btn-primary"> update Contact</button>
            </div>
        </form>
        <h1>Contacts</h1>
        <table class="table table-condensed">
            <thead>
                <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Actions</th>
                </tr>
            </thead>
            <tbody  v-for="contact in list" v-bind:key="contact.id">
                <tr>
                <td>{{contact.name}}</td>
                <td>{{contact.email}}</td>
                <td>{{contact.phone}}</td>
                <td><button  @click="fetchSingleContact(contact.id)" class="btn btn-sm btn-primary">Edit</button></td>
                <td><button  @click="deleteContact(contact.id)" class="btn btn-sm btn-danger">Delete</button></td>
                </tr>
            </tbody>
        </table>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" @click="fetchList(pagination.prev_page_url)">Prev</a></li>
                <li class="page-item"  v-for="n in pagination.last_page" v-bind:class="[{active: pagination.current_page == n}]"><a @click="fetchList(pagination.path_page+n)"  class="page-link" href="#!">{{n}}</a></li>
                <!--<li class="page-item disabled"><a href="#" class="page-link text-dark"> Page {{pagination.current_page}} of {{pagination.last_page}} </a> </li>-->
                <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" @click="fetchList(pagination.next_page_url)">Next</a></li>
            </ul>
        </nav>
    </div>
</template>
<script>
    export default {
        data(){
            return{
                edit:false,
                list:[],
                contact:{
                    id:'',
                    name:'',
                    email:'',
                    phone:''
                },
                pagination:{},
                total:0
            };
        },
        mounted(){
            this.fetchList();
        },
        methods:{
            fetchList(page_url){
                // console.log(page_url);
                let vm = this;
                page_url = page_url || 'api/contacts';
                console.log(page_url);
                fetch(page_url)
                    .then(response=> response.json())
                    .then(response=> {
                        console.log(response);
                         this.list = response.data;
                         vm.makePagination(response);
                    }).catch((error) => {
                    console.log(error);
                })
            },
            createContact(){
                let self = this;
                let params = Object.assign({}, self.contact);
                axios.post('api/contact/store', params)
                    .then(function (){
                        self.contact.name='';
                        self.contact.email='';
                        self.contact.phone='';
                        self.edit=false;
                        self.fetchList();
                    })
                    .catch(function (error){

                    })
            },
            updateContact(id){
                let self = this;
                let params = Object.assign({}, self.contact);
                axios.patch('api/contact/'+id, params)
                    .then(function(){
                        self.contact.name='';
                        self.contact.email='';
                        self.contact.phone='';
                        self.edit = false;
                        self.fetchList();
                    })
                    .catch(function (error){
                    })
            },
            deleteContact(id){
                let self = this;
                axios.delete('api/contact/'+id)
                    .then(function(res){
                        console.log(res);
                        self.fetchList();
                    }).catch(function (err) {
                })
            },
            fetchSingleContact(id){
                axios.get('api/contact/'+id).then((response)=>{
                    let result = response.data;
                    this.contact.id = result.id;
                    this.contact.name = result.name;
                    this.contact.phone = result.phone;
                    this.contact.email = result.email;
                }).catch(function (error) {
                });
                this.edit =true;
            },
            makePagination(res){
                console.log(res);
             let pagination = {
                 current_page : res.current_page,
                 last_page : res.last_page,
                 next_page_url : res.next_page_url,
                 prev_page_url :res.prev_page_url,
                 path_page: res.path+"?page="
             };
             this.pagination = pagination;
            }
        }
    }
</script>