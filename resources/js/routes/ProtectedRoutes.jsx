import { Navigate, Outlet } from "react-router-dom";

export default function ProtectedRoutes({loggedIn}) {
    const isAuth = localStorage.getItem('loggedIn') ? localStorage.getItem('loggedIn') : loggedIn;
    
    return isAuth ? <Outlet /> : <Navigate to="/login" />
}
