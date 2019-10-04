<script>
    export default {
    	data: function () {
            return {
            	query: '',
                options: [
                    ],
                item: {
                    value: '',
                    text: ''
                },
                itemOptions: [],
                newItem: {},
                billItems: [],
                selectFlag: false,
                makeRequest: true,
                magic_flag: true
            }
        },
        
        mounted() {
            this.focusOnSearch();
        },

        methods: {
            addItem() {
                //console.log("Oh Yeah!!");
                // if (this.timer) {
                //     clearTimeout(this.timer);
                //     this.timer = null;
                // }
                // this.timer = setTimeout(() => {
                //     if (this.search.length > 3) {
                //         console.log("Searching.....")
                //     }
                // }, 1000);
            },

            onSearch(search, loading) {

                //loading(true);
                //this.search(loading, search, this);
                
                if (this.timer) {
                    clearTimeout(this.timer);
                    this.timer = null;
                }
                this.timer = setTimeout(() => {
                    let test = search;
                    if (search.length == 0) {
                        test = this.$refs.test._data._value;
                    }
                    if (test.length > 3) {
                        this.search(loading, search, this);
                    }
                }, 750);
            },

            askForQty() {
                Swal.fire({
                    title: 'Kitne Chahiye??',
                    input: 'number',
                    inputAttributes: {
                        min: 1,
                    },
                    inputPlaceholder: 'How Many?'
                })
                .then(text => {
                    if (!isNaN(text.value)) {
                        this.newItem.qty = text.value;
                    }
                    this.focusOnSearch();
                });
            },

            search (loading, search, vm) {
                // console.log(search);
                // console.log(this.$refs.test._data._value);
                if(!this.makeRequest) {
                    return;
                }
                let query = search;
                if (search.length == 0) {
                    query = this.$refs.test._data._value;
                }
                axios.get(`api/get-items/${query}`)
                .then(response => {
                    vm.options = [];
                    this.selectFlag = false;
                    this.itemOptions = [];
                    if (response.data == 'No Products Found.') {
                        vm.options.push("Sorry, I got nothing here Man!");
                        this.selectFlag = true;
                        return;
                    }

                    if (response.data.length > 1) {
                        _.forEach(response.data, (value, key) => {
                            vm.options.push(value.name + " MRP-" + value.mrp);
                            this.itemOptions.push({
                                id: value.name + " MRP-" + value.mrp,
                                product_id: value.product_id,
                                batch_id: value.batch_id,
                                name: value.name,
                                mrp: value.mrp,
                                tax: value.tax,
                            });
                        });
                        this.makeRequest = false;
                        this.selectFlag = true;
                    } else {
                        vm.options.push(response.data[0].name + " MRP-" + response.data[0].mrp);
                        this.$refs.test._data._value = response.data[0].name + " MRP-" + response.data[0].mrp;
                        this.newItem = {
                            id: response.data[0].name + " MRP-" + response.data[0].mrp,
                            name: response.data[0].name,
                            mrp: response.data[0].mrp,
                            tax: response.data[0].tax,
                            product_id: response.data[0].product_id,
                            batch_id: response.data[0].batch_id,
                            qty: 1,
                        };
                        // this.askForQty();
                        this.addToBill();
                        this.makeRequest = true;
                        this.resetSearch();
                    }
                    
                }).catch(error => {
                    if (error.response.status === 422) {
                      this.errors = error.response.data.errors || {};
                    }
                });
            },

            addToBill() {
                console.log(this.checkIfAdded());
                if (this.checkIfAdded()) {
                    this.test();
                    return;
                }
                this.billItems.push(this.newItem);
                if (this.timer3) {
                    clearTimeout(this.timer3);
                    this.timer3 = null;
                }
                this.timer3 = setTimeout(() => {
                    var container = this.$el.querySelector("#billing-table");
                    container.scrollTop = container.scrollHeight;
                }, 50);
            },

            increaseQty(billItem) {
                billItem.qty = parseInt(billItem.qty) + 1;
            },

            decreaseQty(billItem) {
                if (parseInt(billItem.qty) > 1) {
                    billItem.qty = parseInt(billItem.qty) - 1;
                }
            },

            removeItem(index) {
                this.$delete(this.billItems,index);
            },

            changed() {
                if(this.selectFlag) {

                    if (this.timer2) {
                        clearTimeout(this.timer2);
                        this.timer2 = null;
                    }
                    this.timer2 = setTimeout(() => {
                        let item = _.find(this.itemOptions, { 'id': this.$refs.test._data._value });
                        if (item) {
                            this.newItem = {
                                id: item.name + " MRP-" + item.mrp,
                                name: item.name,
                                mrp: item.mrp,
                                tax: item.tax,
                                product_id: item.product_id,
                                batch_id: item.batch_id,
                                qty: 1,
                            };
                            // this.askForQty();
                            this.addToBill();
                            this.resetSearch();
                            this.focusOnSearch();
                        }                
                    }, 200);
                }
            },

            resetSearch() {
                this.$refs.test._data._value = '';
                this.options = [];
                this.selectFlag = true;
                this.makeRequest = true;
                this.focusOnSearch();
            },

            focusOnSearch() {
                document.getElementsByClassName("vs__search")[0].focus();
            },

            myFunction() {
                this.makeRequest = true;
                this.options = [];
            },

            checkIfAdded() {
                if(_.find(this.billItems, { 'product_id': this.newItem.product_id, 'batch_id': this.newItem.batch_id })) {
                    return true;
                }
                return false;
            },

            test() {
                Swal.fire({
                    position: 'top-center',
                    type: 'warning',
                    title: 'Dude! this item is already added. Update the Quanity instead.',
                    showConfirmButton: true,
                    confirmButtonText: 'Oh! Okay Okay'
                })
            }


        }
    }
</script>