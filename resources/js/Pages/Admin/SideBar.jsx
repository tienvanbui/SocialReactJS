import React, { useState } from "react";
import DashboardIcon from "@mui/icons-material/Dashboard";
import BarChartIcon from "@mui/icons-material/BarChart";
import DescriptionIcon from "@mui/icons-material/Description";
import LayersIcon from "@mui/icons-material/Layers";
import ArrowDropUpIcon from "@mui/icons-material/ArrowDropUp";
import ArrowDropDownIcon from "@mui/icons-material/ArrowDropDown";
import "../../../css/admin/common/side-bar.css";

function Menu() {
    const [isClickSubMenu, setClickSubMenu] = useState("dashboard");
    const MenuItems = [
        {
            segment: "dashboard",
            title: "Dashboard",
            path: "/dashboard",
            route: "/dashboard",
            icon: <DashboardIcon />,
            isActive: false,
        },
        {
            segment: "reports",
            title: "Reports",
            path: "/reports",
            route: "/reports",
            icon: <BarChartIcon />,
            isActive: false,
            children: [
                {
                    segment: "sales",
                    title: "Sales",
                    path: "/reports/sales",
                    route: "/sales",
                    icon: <DescriptionIcon />,
                },
                {
                    segment: "traffic",
                    title: "Traffic",
                    path: "/reports/traffic",
                    route: "/traffic",
                    icon: <DescriptionIcon />,
                },
            ],
        },
        {
            segment: "news",
            title: "News",
            path: "/news",
            route: "/news",
            icon: <LayersIcon />,
            isActive: false,
        },
    ];

    const menuSegmentHasChildren = MenuItems.filter(
        (item) => item.children
    ).map((item) => item.segment);

    const handleClickMenuItem = (segment) => {
        const getClickedSegment = MenuItems.filter(
            (item) => item.segment == segment
        );

        const isHasChildren =
            getClickedSegment[0] && getClickedSegment[0].children
                ? true
                : false;
        if (isHasChildren) {
            if (menuSegmentHasChildren.includes(isClickSubMenu)) {
                setClickSubMenu("dashboard");
            } else {
                setClickSubMenu(getClickedSegment[0].segment);
            }
        }
        if (getClickedSegment[0]) {
            getClickedSegment[0].isActive = true;
            setClickSubMenu(getClickedSegment[0].segment);
        }
    };

    return (
        <ul className="menu">
            {MenuItems.map((MenuItem, index) => (
                <div key={index} className="text-white menu_item">
                    {!MenuItem.children && (
                        <div
                            className="flex items-center"
                            onClick={() =>
                                handleClickMenuItem(MenuItem.segment)
                            }
                        >
                            <div className="mr-2">{MenuItem.icon}</div>
                            <div>{MenuItem.title}</div>
                        </div>
                    )}
                    {MenuItem.children && MenuItem.children.length > 0 && (
                        <div>
                            <div
                                className="flex items-center justify-between"
                                onClick={() =>
                                    handleClickMenuItem(MenuItem.segment)
                                }
                            >
                                <div className="flex items-center">
                                    <div className="mr-2">{MenuItem.icon}</div>
                                    <div>{MenuItem.title}</div>
                                </div>
                                <div>{MenuItem.isActive}</div>
                                <div>
                                    {MenuItem.isActive ? (
                                        <ArrowDropUpIcon />
                                    ) : (
                                        <ArrowDropDownIcon />
                                    )}
                                </div>
                            </div>
                            <ul className="menu_item-sub">
                                {MenuItem.children.map((menuSubItem, index) => (
                                    <div key={index}>
                                        {menuSegmentHasChildren.includes(
                                            isClickSubMenu
                                        ) && (
                                            <div
                                                className="flex items-center menu_item-sub-item"
                                                onClick={() =>
                                                    handleClickMenuItem(
                                                        menuSubItem.segment
                                                    )
                                                }
                                            >
                                                <div className="mr-2">
                                                    {menuSubItem.icon}
                                                </div>
                                                <div>{menuSubItem.title}</div>
                                            </div>
                                        )}
                                    </div>
                                ))}
                            </ul>
                        </div>
                    )}
                </div>
            ))}
        </ul>
    );
}
function SideBar({ isOpenSideBar, setOpenSideBar }) {
    return (
        <div className="w-[15%] bg-black h-screen">
            <div className="h-[50px] text-white flex items-center justify-center uppercase text-3xl font-bold border-b-[0.5px] border-solid border-white">
                Social
            </div>
            {isOpenSideBar && (
                <div className="w-full">
                    <Menu />
                </div>
            )}
        </div>
    );
}

export default SideBar;
