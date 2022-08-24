import React, {useState} from 'react'
import {Route, Routes} from 'react-router-dom';
import Login from '../components/Login';
import ProtectedRoutes from './ProtectedRoutes';
import AdminIndex from '../pages/admins/AdminIndex';
import AdminCreate from '../pages/admins/AdminCreate';
import AdminUpdate from '../pages/admins/AdminUpdate';
import SiteIndex from '../pages/sites/SiteIndex';
import SiteCreate from '../pages/sites/SiteCreate';
import SiteUpdate from '../pages/sites/SiteUpdate';
import SiteCategoryIndex from '../pages/site-category/SiteCategoryIndex';
import SiteCategoryCreate from '../pages/site-category/SiteCategoryCreate';
import SiteCategoryUpdate from '../pages/site-category/SiteCategoryUpdate';
import BannerIndex from '../pages/banners/BannerIndex';
import BannerCreate from '../pages/banners/BannerCreate';
import BannerUpdate from '../pages/banners/BannerUpdate';
import LogIndex from '../pages/logs/LogIndex';
import Page404 from '../pages/404/Page404';

export default function Router() {
    const [loggedIn, setLoggedIn] = useState(
        localStorage.getItem('loggedIn') === true || false
    );

    const login = () => {
        setLoggedIn(true);
        localStorage.setItem('loggedIn', true)
    };

    return (
        <div>
            <Routes>
                <Route exact path="/login" element={<Login login={login}/>}/>
                     <Route element={<ProtectedRoutes loggedIn={loggedIn}/>}>
                        {/* <Route exact path="/" element={<Index/>}/> */}
                        <Route exact path="/admins" element={<AdminIndex/>}/>
                        <Route path="/admin/create" element={<AdminCreate/>}/>
                        <Route path="/admin/:id/edit" element={<AdminUpdate/>}/>
                        <Route exact path="/sites" element={<SiteIndex/>}/>
                        <Route path="/site/create" element={<SiteCreate/>}/>
                        <Route path="/site/:id/edit" element={<SiteUpdate/>}/>
                        <Route path="/banners" element={<BannerIndex/>}/>
                        <Route path="/banner/create" element={<BannerCreate/>}/>
                        <Route path="/banner/:id/edit" element={<BannerUpdate />} />
                        <Route path="/site-categories" element={<SiteCategoryIndex/>}/>
                        <Route path="/site-category/create" element={<SiteCategoryCreate/>}/>
                        <Route path="/site-category/:id/edit" element={<SiteCategoryUpdate />} />
                        <Route path="/logs" element={<LogIndex/>}/>
                    </Route> 
                    <Route path='*' element={<Page404/>}/>
            </Routes>
        </div>
    )
}
