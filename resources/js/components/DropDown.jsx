import React, {useState} from 'react';
import apiClient from "../services/Api";
import {useNavigate} from "react-router-dom";

export default function DropDown() {

    const nav = useNavigate();
    const token = JSON.parse(localStorage.getItem('authInfo'));

    const [loggedIn, setLoggedIn] = useState(true);

    const logout = async () => {
        apiClient.get('/api/logout', {
            'headers': {
                "Authorization": `Bearer ${token.access_token}`
            }
        }).then(response => {
            if (response.status === 200) {
                setLoggedIn(false);
                localStorage.clear();
                nav("/login");
            }
        })
    }


    const [isOpen, setOpen] = useState(false);
    const toggleOpen = () => {
        setOpen(!isOpen)
    }
    const menuClass = `dropdown-menu${isOpen ? " show" : ""}`;
    return (
        <div>
            <div className="dropdown" onClick={() => toggleOpen()}>
                <div className="avatar avatar-online">
                    <img src="../../assets/img/avatars/1.png" alt="test"
                            className="w-px-40 h-auto rounded-circle"/>
                </div>
                <div className={menuClass} aria-labelledby="dropdownMenuButton">
                    <a className="dropdown-item" href="#admin">
                        <div className="d-flex">
                        <div className="flex-shrink-0 me-3">
                            <div className="avatar avatar-online">
                            <img src="../../assets/img/avatars/1.png" alt={token.user.name} className="w-px-40 h-auto rounded-circle" />
                            </div>
                        </div>
                        <div className="flex-grow-1">
                            <span className="fw-semibold d-block">{token.user.name}</span>
                            <small className="text-muted">Admin</small>
                        </div>
                        </div>
                    </a>
                    <a className="dropdown-item" href="#profile">
                        Hesab
                    </a>
 
                    <a className="dropdown-item" href="#logout" onClick={logout}>
                        Çıxış
                    </a>
                </div>
            </div>
        </div>
    )
}
