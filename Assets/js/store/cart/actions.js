
export const GET_CART = ({commit, dispatch, state, rootState}, refresh = false) => {
  return new Promise(async (resolve, reject) => {
    let cartId = state.cartId
    let cart = await  cache.get.item('apiRoutes.qcommerce.cart')
    if (cart)
      cartId = cart.data.id

    if (cartId) {
      axios.get("/api/icommerce/v3/carts/"+cart_id).then(response => {
        commit('SET_CART', response.data)
        resolve(true)
      }).catch(error => {
        reject(error)
      })
    } else {
      resolve(true)
    }
  })
}

export const SET_PRODUCT_INTO_CART = ({commit, dispatch, state, rootState}, product) => {
  return new Promise(async (resolve, reject) => {
    let cartId = state.cartId

    if (!cartId) {
      let data = {
        total: 0,
        status: 1,
      }
      if (rootState.quserAuth.authenticated) {
        data.userId = rootState.quserAuth.userId
      }
      let response = await axios.create('/api/icommerce/v3/carts', data);
      commit('SET_CART', response.data)
    }
    product.cartId = state.cartId
    axios.create('/api/icommerce/v3/cart-products', product).then(async response => {
      await dispatch('GET_CART', true)
      toastr.success({message : "Producto Añadido Exitosamente"})
      resolve(true)
    }).catch(error => {
      toastr.error({message : "Ha ocurrido un error al añadir el producto", pos : 'bottom'})
      reject(error)
    })
  })
}

export const UPDATE_PRODUCT_INTO_CART = ({commit, dispatch, state, rootState}, item) => {
  return new Promise(async (resolve, reject) => {
    let cartId = state.cartId

    if (cartId) {
      item.cartId = cartId
      axios.update('/api/icommerce/v3/cart-products/'+ item.id, item).then(response => {
        dispatch('GET_CART', true)
        toastr.success({message : "Producto Actualizado Exitosamente"})
        resolve(true)
      }).catch(error => {
        toastr.error({message : "Ha ocurrido un error al actualizar el producto", pos : 'bottom'})
        reject(error)
      })
    }
  })
}

export const DEL_PRODUCT_FROM_CART = ({commit, dispatch, state, rootState}, itemId) => {
  return new Promise(async (resolve, reject) => {
    let cartId = state.cartId
    if (cartId) {
      axios.delete('/api/icommerce/v3/cart-products/'+ item.id).then(response => {
        dispatch('GET_CART', true)
        toastr.success({message : "Producto Borrado Exitosamente"})
        resolve(true)
      }).catch(error => {
        toastr.error({message : "Ha ocurrido un error al borrar el producto", pos : 'bottom'})
        reject(error)
      })
    } else {
      toastr.error({message : "Ha ocurrido un error al borrar el producto", pos : 'bottom'})
      reject(error)
    }
  })
}

export const SELECT_PAYMENT_METHOD = ({commit, dispatch, state, rootState}, itemId) => {
  return new Promise(async (resolve, reject) => {
    commit('SET_PAYMENT_METHOD', response.data)
  })
}

export const ADD_USER_TO_CART = ({commit, dispatch, state, rootState}) => {
  return new Promise(async (resolve, reject) => {
    let cartId = state.cartId
    let cart = await helper.storage.get.item('apiRoutes.qcommerce.cart')
    if (cart)
      cartId = cart.data.id

    if (cartId) {
      let params = {
        user_id: store.state.quserAuth.userId
      }
      crud.update('apiRoutes.qcommerce.cart', cartId, params).then(response => {
        commit('SET_CART', response.data)
        resolve(true)
      }).catch(error => {
        reject(error)
      })
    } else {
      resolve(true)
    }
  })
}

export const CLEAR_CART = ({commit, dispatch, state, rootState}, product) => {
  return new Promise(async (resolve, reject) => {
    await commit('CLEAR_CART')//Clear Store
    helper.storage.remove('apiRoutes.qcommerce.cart')//Claer Cache
  })
}
