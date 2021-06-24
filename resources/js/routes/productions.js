import productions from '@/pages/productions/index';
import create from '@/pages/productions/create';
import update from '@/pages/productions/update';
import show from '@/pages/productions/show';
const baseDash= '/dashboard';

export default [
    {
        path: `${baseDash}/productions`,
        name: `productions`,
        component: productions,
    },
    {
        path: `${baseDash}/productions/create`,
        name: `productionsCreate`,
        component: create,
    },
    {
        path: `${baseDash}/productions/update/:id`,
        name: `productionsUpdate`,
        component: update,
    },
    {
        path: `${baseDash}/productions/:id`,
        name: `productionsShow`,
        component: show,
    }
];
