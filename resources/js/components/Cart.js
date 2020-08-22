import React, { Component } from 'react'
import ReactDOM from 'react-dom'
import axios from 'axios'
import Swal from 'sweetalert2'
import {sum} from 'lodash'

export default class Cart extends Component {

    constructor(props) {
        super(props)
        this.state = {
            cart: [],
            produk: [],
            customer: [],
            barcode: '',
            search: '',
            customer_id: ''
        };

        this.loadCart = this.loadCart.bind(this);
        this.loadProduk = this.loadProduk.bind(this);
        this.handleOnChangeBarcode = this.handleOnChangeBarcode.bind(this);
        this.handleScanBarcode = this.handleScanBarcode.bind(this);
        this.handleChangeQty = this.handleChangeQty.bind(this);
        this.handleEmptyCart = this.handleEmptyCart.bind(this);
        this.handleChangeSearch = this.handleChangeSearch.bind(this);
        this.handleSearch = this.handleSearch.bind(this);
        this.setCustomerId = this.setCustomerId.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
    }

    componentDidMount() {
        this.loadCart();
        this.loadProduk();
        this.loadCustomer();
    }

    handleOnChangeBarcode(event) {
        const barcode = event.target.value;
        this.setState({barcode});
    }

    handleScanBarcode(event) {
        event.preventDefault();
        const {barcode} = this.state;
        if (!!barcode) {
            axios.post('/admin/cart', {barcode}).then(res => {
                this.loadCart();
                this.setState({barcode: ''})
            })
            .catch(err => {
                Swal.fire(
                    'Error!',
                    err.response.data.message,
                    'error'
                );
            })
        }
    }

    handleChangeQty(produk_id, qty) {
        const cart = this.state.cart.map(c => {
            if (c.id === produk_id) {
                c.pivot.quantity = qty;
            }
            return c;
        });

        this.setState({cart});

        axios.post('/admin/cart/change-qty', {produk_id, quantity: qty})
            .then(res => {

            })
            .catch(err => {
                Swal.fire(
                    'Error!',
                    err.response.data.message,
                    'error'
                );
            });
    }

    handleDelete(produk_id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.value) {
                axios.post('/admin/cart/delete', {produk_id, _method: 'DELETE'})
                    .then(res => {
                        const cart = this.state.cart.filter(c => c.id !== produk_id);
                        this.setState({cart});
                    })
            }
          })        
    }

    handleEmptyCart() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, empty the cart!'
          }).then((result) => {
            if (result.value) {
                axios.post('/admin/cart/empty', {_method: 'DELETE'})
                    .then(res => {
                        this.setState({cart: []});
                    })
            }
          })
    }

    handleChangeSearch(event) {
        const search = event.target.value;
        this.setState({search});
    }

    handleSearch(event) {
        if(event.keyCode === 13) {
            this.loadProduk(event.target.value);
        }
    }

    setCustomerId(event) {
        this.setState({customer_id: event.target.value});
    }

    addProdukToCart(barcode) {
        axios.post('/admin/cart', {barcode}).then(res => {
            this.loadCart();
            this.setState({barcode: ''})
        })
        .catch(err => {
            Swal.fire(
                'Error!',
                err.response.data.message,
                'error'
            );
        })
    }

    getTotal(cart) {
        const total = cart.map(c => c.pivot.quantity * c.harga);
        return sum(total);
    }

    handleSubmit() {
        Swal.fire({
            title: 'Total Harga',
            input: 'text',
            inputValue: this.getTotal(this.state.cart),
            showCancelButton: true,
            confirmButtonText: 'Submit',
            showLoaderOnConfirm: true,
            preConfirm: (amount) => {
                return axios.post('/admin/orders', {customer_id: this.state.customer_id, amount})
                .then(res => {
                    this.loadCart();
                    return res.data;
                })
                .catch(err => {
                    console.log(err.response.data.message);
                    Swal.showValidationMessage(err.response.data.message)
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
          }).then((result) => {

          })
        
    }

    loadCustomer() {
        axios.get('/admin/customer').then(res => {
            const customer = res.data;
            this.setState({customer});
        })
    }

    loadCart() {
        axios.get('/admin/cart').then( res => {
            const cart = res.data
            this.setState({cart})
        })
    }

    loadProduk(search = '') {
        const query = !!search ? `?search=${search}` : '';
        axios.get(`/admin/produk${query}`).then(res => {
            const produk = res.data.data;
            this.setState({produk})
        })
    }

    render() {
        const {cart, produk, customer, barcode} = this.state;
        return (
            <div className="row">
            <div className="col-md-6 col-lg-4">
                <div className="row mb-2">
                    <div className="col">
                        <form onSubmit={this.handleScanBarcode}>
                            <input 
                                type="text" 
                                className="form-control" 
                                placeholder="Scan Barcode"
                                value={barcode}
                                onChange={this.handleOnChangeBarcode} 
                            />
                        </form>
                    </div>
                    <div className="col">
                        <select 
                            className="form-control"
                            onChange={this.setCustomerId}
                        >
                            <option value="">Walking Customer</option>
                            {customer.map(cus => <option key={cus.id} value={cus.id}>{cus.nama}</option>)}
                        </select>
                    </div>
                </div>
                <div className="user-cart">
                    <div className="card">
                        <table className="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nama Produk</th>
                                    <th>Quantity</th>
                                    <th className="text-right">Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                {cart.map(c => (
                                    <tr key={c.id}>
                                        <td>{c.nama}</td>
                                        <td>
                                            <input 
                                                type="number" 
                                                className="form-control form-control-sm qty" 
                                                value={c.pivot.quantity} 
                                                onChange={event => this.handleChangeQty(c.id, event.target.value)}
                                            />
                                            <button 
                                                className="btn btn-danger btn-sm"
                                                onClick={() => this.handleDelete(c.id)}
                                            >
                                                <i className="fas fa-trash"></i>
                                            </button>
                                        </td>
                                        <td className="text-right">{window.APP.simbol}  {c.harga * c.pivot.quantity}</td>
                                    </tr>
                                ))}                                
                            </tbody>
                        </table>
                    </div>
                </div>

                <div className="row">
                    <div className="col">Total:</div>
                    <div className="col text-right">{window.APP.simbol} { this.getTotal(cart) }</div>
                </div>
                <div className="row">
                    <div className="col">
                        <button 
                            type="button" 
                            className="btn btn-danger btn-block"
                            onClick={this.handleEmptyCart}
                            disabled={!cart.length}
                        >Reset</button>
                    </div>
                    <div className="col">
                        <button 
                            type="button" 
                            className="btn btn-primary btn-block"
                            disabled={!cart.length}
                            onClick={this.handleSubmit}
                        >Submit</button>
                    </div>
                </div>
            </div>
            <div className="col-md-6 col-lg-8">
                <div className="mb-2">
                    <input 
                        type="text" 
                        className="form-control" 
                        placeholder="Cari Produk..." 
                        onChange={this.handleChangeSearch}
                        onKeyDown={this.handleSearch}
                    />
                </div>
                <div className="order-product">
                    {produk.map(p => (
                        <div 
                        onClick={() => this.addProdukToCart(p.barcode)}
                        className="item" 
                        key={p.id}
                        style={{cursor:'pointer'}}
                        >
                            <img src={p.image_url} alt="" />
                            <h5>{p.nama}</h5>
                        </div> 
                    ))}
                </div>
            </div>
        </div>
        )
    }
}

if(document.getElementById('cart')) {
    ReactDOM.render(<Cart />, document.getElementById('cart'))
}