<template>
  <div>
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h3>Transactions Details</h3>
      </div>
     <div class="card-body">
        <p><span class="text-bold">Action</span> {{transaction.action}}</p>
        <p><span class="text-bold">Custom Transaction ID </span>{{transaction.custom_transaction_id}}</p>
        <p><span class="text-bold">Amount </span>{{transaction.amount}}</p>
        <p><span class="text-bold">Method </span>{{transaction.method}}</p>
        <p><span class="text-bold">Ref ID </span>{{transaction.ref_id}}</p>
        <p><span class="text-bold">Status </span>{{transaction.status}}</p>
        <p><span class="text-bold">User Name </span>{{transaction.user.firstname}} {{transaction.user.lastname}}</p>
        <p><span class="text-bold">User balance </span>Rs. {{transaction.user.balance}}</p>
        <p><span class="text-bold">Esewa ID </span>{{transaction.user.details.esewa_id}}</p>
        <p><span class="text-bold">Khalti ID </span>{{transaction.user.details.khalti_id}}</p>
        <div v-if="transaction.status==='pending'">
            <button class="btn btn-success" @click="approveTransaction(transaction.id)">Approve Transaction</button>
            <button class="btn btn-danger" @click="cancelTransaction(transaction.id)">Cancel Transaction</button>
        </div>
     </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {

  data() {
    return {
      isLoading: '',

      transactions:{},
        transaction_id:'',
        transaction:{

            action:'',
            custom_transaction_id:'',
            amount:'',
            method:'',
            ref_id:'',
            status:'',
            user:{
                firstname:'',
                lastname:'',
                balance:'',
                details:{
                    esewa_id:'',
                    khalti_id:'',
                }
            }
        }
    }
  },
    watch: {
    $route: function() {
      this.getIdFromUrl();
    },
  },
  created() {
    //this block will execute when component created
    this.getIdFromUrl();
  },

  methods: {

   getIdFromUrl() {
      this.scrollToTop(); //take page to top
      this.transaction_id = this.$route.params.transaction_id; //get book slug from the url.
      this.getTransaction();
    },
     scrollToTop() {
      window.scrollTo(0, 0);
    },

    getTransaction(){
          this.$http.get('transaction/'+this.transaction_id)
      .then((response)=>{
        this.transaction=response.data.data[0];
      })
      .catch((error)=>{
        console.log(error.response.data);
      })
    },
    approveTransaction(){
         this.$swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        showCancelButton: true,
        confirmButtonColor: '#1e7e34',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, approve it!'
      }).then((result) => {

        if (result.value) {
          
            let formData=new FormData();
            formData.append('transaction_id',this.transaction.id);
            formData.append('user_id',this.transaction.user.id);
            formData.append('status','approved')

           this.$http.post('transaction/status', formData)
           .then((response)=>{
               if(response.data.message === 'success'){ 
                   this.transaction.status="approved";
               }
               this.$swal("Info", response.data.message, response.data.status);

           })
           .catch((error)=>{

               this.$swal("Info", error.response.data.message,'error');


           });

        }


      });
    },
    cancelTransaction(){
         this.$swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, cancel it!'
      }).then((result) => {

        if (result.value) {
          
            let formData=new FormData();
            formData.append('transaction_id',this.transaction.id);
            formData.append('user_id',this.transaction.user.id);
            formData.append('status','cancel')

           this.$http.post('transaction/status', formData)
           .then((response)=>{
               if(response.data.message === 'success'){ 
                   this.transaction.status="approved";
               }
               this.$swal("Info", response.data.message, response.data.status);

           })
           .catch((error)=>{

               this.$swal("Info", error.response.data.message,'error');


           });
        }


      });
    },

    //end of methods block
  }

}
</script>
<style>
.text-bold{
    font-weight:bold;
}

</style>
