export const SessionStorage = {
    getSessionStorage: (key) => {
        return sessionStorage.getItem(key)
    },
    setSessionStorage: (key, item) => {
        sessionStorage.setItem(key, item)
    },
    clearSessionStorage: (key) => {
        sessionStorage.removeItem(key)
    }
}
