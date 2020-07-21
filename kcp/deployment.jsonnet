local values = import "./values.json";

{
  apiVersion: "v1",
  kind: "List",
  items: [
    {
      apiVersion: "apps/v1",
      kind: "Deployment",
      metadata: {
        name: "web",
        labels: {
          "app.kubernetes.io/name": "web"
        }
      },
      spec: {
        replicas: 1,
        selector: {
          matchLabels: {
            "app.kubernetes.io/name": "web"
          }
        },
        template: {
          metadata: {
            labels: {
              "app.kubernetes.io/name": "web"
            }
          },
          spec: {
            containers: [
              {
                name: "server",
                image: "registry.oddin.org/web",
                imagePullPolicy: "Always",
                env: [
                  {
                    name: "WS_URL",
                    value: values.ws_url
                  }
                ]
              }
            ]
          }
        }
      }
    },
    {
      kind: "Service",
      apiVersion: "v1",
      metadata: {
        name: "web",
        labels: {
          "app.kubernetes.io/name": "web"
        }
      },
      spec: {
        selector: {
          "app.kubernetes.io/name": "web"
        },
        type: "ClusterIP",
        ports: [
          {
            name: "http",
            protocol: "TCP",
            port: 80,
            targetPort: 3000
          }
        ]
      }
    },
    {
      apiVersion: "projectcontour.io/v1",
      kind: "HTTPProxy",
      metadata: {
        name: "web"
      },
      spec: {
        virtualhost: {
          fqdn: "oddin.localhost",
          tls: {
            secretName: "domain-tls"
          }
        },
        routes: [
          {
            conditions: [
              {
                prefix: "/"
              }
            ],
            services: [
              {
                name: "web",
                port: 80
              }
            ]
          }
        ]
      }
    }
  ]
}
