import matrials_types from '@/pages/matrials_types/index';
import create from '@/pages/matrials_types/create';
import update from '@/pages/matrials_types/update';
import show from '@/pages/matrials_types/show';
const baseDash= '/dashboard';

export default [
    {
        path: `${baseDash}/matrials_types`,
        name: `matrials_types`,
        component: matrials_types,
    },
    {
        path: `${baseDash}/matrials_types/create`,
        name: `matrials_typesCreate`,
        component: create,
    },
    {
        path: `${baseDash}/matrials_types/update/:id`,
        name: `matrials_typesUpdate`,
        component: update,
    },
    {
        path: `${baseDash}/matrials_types/:id`,
        name: `matrials_typesShow`,
        component: show,
    }
];
