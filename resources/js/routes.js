
// core components/views for Admin layout
import Frontend from "views/Frontend/Frontend";
import Login from "views/Auth/Login";

const dashboardRoutes = [
  /*{
    path: "/dashboard",
    name: "Dashboard",
    showOnDashboard: true,
    icon: Dashboard,
    component: DashboardPage,
    layout: "/admin"
  },*/
  {
    path: "/",
    name: "home",
    component: Frontend,
    showOnDashboard: false,
    layout: "/Frontend"
  },
  {
    path: "/login",
    name: "login",
    component: Login,
    showOnDashboard: true,
    layout: "/Frontend"
  }
];

export default dashboardRoutes;
