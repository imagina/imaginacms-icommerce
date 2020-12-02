export const RESET = (state) => {
  state.cart = []
  state.cartId = []
  state.paymentMethod = {}

};

export function SET_CART(state, data) {
  state.cart = data
  state.cartId = data.id
}

export function SET_PAYMENT_METHOD(state, data) {
  state.paymemtMethod = data
}

export function CLEAR_CART(state, data) {
  state.cart = []
  state.cartId = null
}
