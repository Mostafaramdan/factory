import bills from '@/pages/bills/index';
import create from '@/pages/bills/create';
import update from '@/pages/bills/update';
import show from '@/pages/bills/show';
const baseDash= '/dashboard';

export default [
    {
        path: `${baseDash}/bills`,
        name: `bills`,
        component: bills,
    },
    {
        path: `${baseDash}/bills/create`,
        name: `billsCreate`,
        component: create,
    },
    {
        path: `${baseDash}/bills/update/:id`,
        name: `billsUpdate`,
        component: update,
    },
    {
        path: `${baseDash}/bills/:id`,
        name: `billsShow`,
        component: show,
    }
];
