import prueba from './components/prueba.vue';

const locales = window.AsgardCMS.locales;

new Vue({
    el: '#optionsProduct',
    components: { prueba }
});

export default [    
    {
        path: '/icommerce/products/create',
        name: 'crud.icommerce.products.create',
        component: prueba,
        props: {
            locales,
            pageTitle: 'create page',
        },
    },

];