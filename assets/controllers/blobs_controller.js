import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    static targets = ["blob"];

    connect() {
        this.blobs = this.blobTargets.map((blob) => ({
            element: blob,
            x: parseFloat(blob.getAttribute("cx")),
            y: parseFloat(blob.getAttribute("cy")),
            vx: (Math.random() - 0.5) * 2, // Random initial velocity
            vy: (Math.random() - 0.5) * 2,
        }));

        this.svg = this.element.querySelector("svg");
        this.width = this.svg.viewBox.baseVal.width;
        this.height = this.svg.viewBox.baseVal.height;

        this.element.addEventListener("mousemove", this.handleMouseMove.bind(this));
        this.animateBlobs();
    }

    handleMouseMove(event) {
        const mousePoint = this.getMousePositionInSVG(event);

        let nearestBlob = null;
        let nearestDistance = Infinity;

        // Find the nearest blob
        this.blobs.forEach((blob) => {
            const dx = blob.x - mousePoint.x;
            const dy = blob.y - mousePoint.y;
            const distance = Math.sqrt(dx * dx + dy * dy);

            if (distance < nearestDistance) {
                nearestDistance = distance;
                nearestBlob = blob;
            }
        });

        // If the nearest blob is within the threshold, animate it
        if (nearestBlob && nearestDistance < 50) {
            const dx = nearestBlob.x - mousePoint.x;
            const dy = nearestBlob.y - mousePoint.y;
            const angle = Math.atan2(dy, dx);

            nearestBlob.vx += Math.cos(angle) * 3; // Stronger push
            nearestBlob.vy += Math.sin(angle) * 3;
        }
    }

    animateBlobs() {
        const damping = 0.98; // Damping factor (reduce velocity by 2% per frame)

        this.blobs.forEach((blob) => {
            // Apply velocity damping
            blob.vx *= damping;
            blob.vy *= damping;

            // Update positions
            blob.x += blob.vx;
            blob.y += blob.vy;

            // Boundary detection and bouncing
            if (blob.x <= 0 || blob.x >= this.width) {
                blob.vx *= -1; // Reverse velocity
                blob.x = Math.min(Math.max(blob.x, 0), this.width); // Clamp position
            }
            if (blob.y <= 0 || blob.y >= this.height) {
                blob.vy *= -1;
                blob.y = Math.min(Math.max(blob.y, 0), this.height);
            }

            // Update blob position in the DOM
            blob.element.setAttribute("cx", blob.x);
            blob.element.setAttribute("cy", blob.y);
        });

        // Request the next animation frame
        requestAnimationFrame(this.animateBlobs.bind(this));
    }

    getMousePositionInSVG(event) {
        const point = this.svg.createSVGPoint();
        point.x = event.clientX;
        point.y = event.clientY;

        const svgPoint = point.matrixTransform(this.svg.getScreenCTM().inverse());
        return { x: svgPoint.x, y: svgPoint.y };
    }
}
