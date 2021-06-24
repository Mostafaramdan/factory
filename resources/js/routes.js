import login from '@/pages/authentication/login';
import employees from '@/routes/employees';
import admins from '@/routes/admins';
import orders from '@/routes/orders';
import returnedOrders from '@/routes/returnedOrders';
import clients from '@/routes/clients';
import variable_costs from '@/routes/variable_costs';
import matrials_types from '@/routes/matrials_types';
import bills from '@/routes/bills';
import statistics from '@/routes/statistics';
import productions from '@/routes/productions';
const baseDash= '/dashboard';

const routes=
[

    ...employees,
    ...admins,
    ...clients,
    ...returnedOrders,
    ...orders,
    ...variable_costs,
    ...matrials_types,
    ...statistics,
    ...productions,
    ...bills,
    {
        path: `${baseDash}/login`,
        name: 'login',
        component: login,
    },
    {
        path: '*',
        redirect: { name: 'statistics' }
    }


];
export default routes;
