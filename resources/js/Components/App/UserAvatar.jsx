const UserAvatar = ({ user, online = null, profile = false }) => {
    const onlineClass =
        online === true ? "online" : online === false ? "offline" : "";
    const sizeClass = profile ? "w-40 h-40" : "w-8 h-8";

    return (
        <div className={`chat-image-avatar ${onlineClass}`}>
            {user.avatar_url ? (
                <div className={`rounded-full overflow-hidden ${sizeClass}`}>
                    <img
                        src={user.avatar_url}
                        alt="User Avatar"
                        className="w-full h-full object-cover"
                    />
                </div>
            ) : (
                <div
                    className={`bg-gray-400 text-gray-800 rounded-full flex items-center justify-center ${sizeClass}`}
                >
                    <span className="text-xl">{user.name.substring(0, 1)}</span>
                </div>
            )}
        </div>
    );
};

export default UserAvatar;
