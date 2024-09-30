import React, { useState } from "react";
import Header from "./Header";
import SideBar from "./SideBar";

function Dashboard() {
    const [isOpenSideBar, setOpenSideBar] = useState(false);
    return (
        <div className="!h-[100vh] overflow-hidden !bg-white">
            <div className="flex">
                {/* SideBar */}
                <SideBar
                    isOpenSideBar={isOpenSideBar}
                    setOpenSideBar={setOpenSideBar}
                />
                <div className="flex flex-col w-[85%]">
                    {/* Header */}
                    <Header
                        isOpenSideBar={isOpenSideBar}
                        setOpenSideBar={setOpenSideBar}
                    />
                </div>
            </div>
        </div>
    );
}

export default Dashboard;
