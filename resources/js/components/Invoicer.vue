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
                magic_flag: true,
                discAmt: null,
                discPercent: null,
                paymentMode: "Cash"
            }
        },
        
        mounted() {
            this.focusOnSearch();
        },

        computed: {
            grandTotal() {
                if (this.billItems.length > 0) {
                    let total = 0;
                    _.forEach(this.billItems, (item, key) => {
                        total += parseFloat(item.mrp) * parseInt(item.qty);
                    });
                    if (this.discAmt) {
                        total -= this.discAmt;
                    } else if(this.discPercent) {
                        total -= total * (this.discPercent/100); 
                    }
                    return total;
                }

                return 0;
            },

            billTotal() {
                if (this.billItems.length > 0) {
                    let total = 0;
                    _.forEach(this.billItems, (item, key) => {
                        total += parseFloat(item.mrp) * parseInt(item.qty);
                    });
                    
                    return total;
                }

                return 0;
            }
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
                        vm.options.push("I got nothing here Man!");
                        this.selectFlag = true;
                        Vue.notify({
                            group: 'foo',
                            title: 'What you  doing bro!',
                            text: 'I got nothing here!',
                            type: 'error',
                            duration: 3000,
                            speed: 1000
                        });
                        this.focusOnSearch();
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
                                qty_avl: parseInt(value.qty),
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
                            qty_avl: parseInt(response.data[0].qty),
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
                    this.notify("Product already added. Update Quantity instead.");
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
                    window.scrollTo({
                        top: document.body.scrollHeight || document.documentElement.scrollHeight,
                        left: 0,
                        behavior: 'smooth'
                    });
                }, 50);
            },

            increaseQty(billItem) {
                if (billItem.qty == billItem.qty_avl) {
                    this.notify("That's all the quantity we have Man!");
                    return;
                }
                billItem.qty = parseInt(billItem.qty) + 1;
            },

            decreaseQty(billItem) {
                if (parseInt(billItem.qty) > 1) {
                    billItem.qty = parseInt(billItem.qty) - 1;
                }
            },

            qtyChanged(val, billItem) {
                if (val >= billItem.qty_avl) {
                    this.notify("Quantity can't be more than " + billItem.qty_avl);
                    billItem.qty = billItem.qty_avl;
                    return;
                }
                // if (val == 0) {
                //     this.notify("Quantity can't be 0. Remove item from the bill instead");
                //     billItem.qty = 1;
                //     return;
                // }
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
                            console.log(item);
                            this.newItem = {
                                id: item.name + " MRP-" + item.mrp,
                                name: item.name,
                                mrp: item.mrp,
                                tax: item.tax,
                                product_id: item.product_id,
                                qty_avl: item.qty_avl,
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

            notify(text) {
                Vue.notify({
                    group: 'foo',
                    title: 'Important message',
                    text: text,
                    type: 'error',
                    duration: 3000,
                    speed: 1000
                });
            },

            test() {
                //window.animate({ scrollTop: document.body.scrollHeight || document.documentElement.scrollHeight }, 400);
                // window.scrollTo(0, document.body.scrollHeight || document.documentElement.scrollHeight);
            },

            calDiscPercent() {
                if (this.discAmt > 0) {
                    this.discPercent = (this.discAmt/this.billTotal) * 100;
                } else {
                    this.discPercent = null;
                }
            },

            calDiscAmt() {
                if (this.discPercent > 0 && this.discPercent < 20) {
                    this.discAmt = (this.discPercent/100) * this.billTotal;
                } else {
                    this.discAmt = null;
                }
            },

            saveAndPrint() {
                if (this.billItems.length == 0) {
                    this.notify("There is nothing to save here!");
                    return;
                }
                this.saveBill(true);
            },

            saveAndClose() {
                if (this.billItems.length == 0) {
                    this.notify("There is nothing to save here!");
                    return;
                }
                this.saveBill();
            },

            saveBill(printBill = false) {
                let data = {};
                data.billItems = this.billItems;
                data.billTotal = this.billTotal;
                data.grandTotal = this.grandTotal;
                data.discAmt = this.discAmt;
                data.discPercent = this.discPercent;
                data.paymentMode = this.paymentMode;
                axios.post("api/invoice", data)
                .then(response => {
                    Vue.notify({
                        group: 'foo',
                        title: 'Yay!',
                        text: 'Saved Successfully!',
                        type: 'success',
                        duration: 3000,
                        speed: 1000
                    });
                    if (printBill) {
                        this.printBill();
                    }
                    this.resetSearch();
                    this.itemOptions = [];
                    this.newItem = {};
                    this.billItems = [];
                    this.selectFlag = false;
                    this.makeRequest = true;
                    this.discAmt = null;
                    this.discPercent = null;
                    this.paymentMode = "Cash";
                }).catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors || {};
                    }
                });
            },

            printBill() {
                this.Popup($(document.getElementById("printMe")).html());
            },

            Popup(data) {
                var mywindow = window.open('', 'new div', 'height=400,width=600');
                mywindow.document.write('<html><head><title></title>');
                mywindow.document.write('<link rel="stylesheet" href="css/app.css" type="text/css" />');
                mywindow.document.write('</head><body >');
                mywindow.document.write(data);
                mywindow.document.write('</body></html>');
                // mywindow.document.close();
                // mywindow.focus();
                setTimeout(() => {
                    mywindow.print();
                    mywindow.close();
                },1000);
                return true;
            },

            print() {
                // Pass the element id here
                // this.$htmlToPaper('printMe');
                
            }
        }
    }
</script>