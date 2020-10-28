{
	deployment: {
		apiVersion: "apps/v1",
		kind: "Deployment",
		metadata: {
			name: _.package.fullName,
			labels: {
				"app.kubernetes.io/name": _.package.fullName,
			},
		},
		spec: {
			replicas: 1,
			selector: {
				matchLabels: $.deployment.metadata.labels,
			},
			template: {
				metadata: {
					labels: $.deployment.metadata.labels,
				},
				spec: {
					containers: [
						{
							name: "server",
							image: "registry.oddin.org/%s:%s" % [_.package.name, _.values.tag],
							imagePullPolicy: "Always",
							env: [
								{
									name: "WS_URL",
									value: _.values.ws_url,
								},
							],
						},
					],
				},
			},
		},
	},
	service: {
		kind: "Service",
		apiVersion: "v1",
		metadata: {
			name: _.package.fullName,
			labels: {
				"app.kubernetes.io/name": _.package.fullName,
			},
		},
		spec: {
			selector: $.deployment.metadata.labels,
			type: "ClusterIP",
			ports: [
				{
					name: "http",
					protocol: "TCP",
					port: 80,
					targetPort: 3000,
				},
			],
		},
	},
	ingress: {
		apiVersion: "projectcontour.io/v1",
		kind: "HTTPProxy",
		metadata: {
			name: _.package.fullName,
		},
		spec: {
			virtualhost: {
				fqdn: _.values.domain,
				tls: { secretName: _.values.tls_secret },
			},
			routes: [
				{
					conditions: [
						{ prefix: "/" },
					],
					services: [
						{
							name: $.service.metadata.name,
							port: 80,
						},
					],
				},
			],
		},
	},
}
